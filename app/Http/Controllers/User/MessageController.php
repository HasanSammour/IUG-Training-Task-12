<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Course;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    /**
     * Show inbox with all conversations
     */
    public function inbox()
    {
        $user = Auth::user();

        // Get all messages where user is sender or receiver
        $messages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver', 'course'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by conversation (other user)
        $conversations = [];
        $processedUsers = [];

        foreach ($messages as $message) {
            $otherUserId = ($message->sender_id == $user->id) ? $message->receiver_id : $message->sender_id;

            if (!in_array($otherUserId, $processedUsers)) {
                $processedUsers[] = $otherUserId;

                // Get the other user
                $otherUser = ($message->sender_id == $user->id) ? $message->receiver : $message->sender;

                // Count unread messages from this conversation
                $unreadCount = Message::where('sender_id', $otherUserId)
                    ->where('receiver_id', $user->id)
                    ->where('is_read', false)
                    ->count();

                $conversations[] = [
                    'user' => $otherUser,
                    'last_message' => $message,
                    'unread_count' => $unreadCount,
                    'course' => $message->course
                ];
            }
        }

        // Get unread count for header
        $unreadCount = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();

        return view('user.messages.inbox', compact('conversations', 'unreadCount'));
    }

    /**
     * Show sent messages
     */
    public function sent()
    {
        $user = Auth::user();

        $messages = Message::where('sender_id', $user->id)
            ->with(['receiver', 'course'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();

        return view('user.messages.sent', compact('messages', 'unreadCount'));
    }

    /**
     * Show conversation with a specific user
     */
    public function conversation(User $otherUser)
    {
        $user = Auth::user();

        // Verify user exists
        if (!$otherUser) {
            abort(404, 'User not found');
        }

        // Get all messages between these two users
        $messages = Message::where(function ($query) use ($user, $otherUser) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $otherUser->id);
        })
            ->orWhere(function ($query) use ($user, $otherUser) {
                $query->where('sender_id', $otherUser->id)
                    ->where('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver', 'course'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('sender_id', $otherUser->id)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        // Get any course context (if from course)
        $courseId = request('course_id');
        $course = null;
        if ($courseId) {
            $course = Course::find($courseId);
        }

        $unreadCount = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();

        return view('user.messages.conversation', compact('messages', 'otherUser', 'course', 'unreadCount'));
    }

    /**
     * Compose new message
     */
    public function compose(User $otherUser = null)
    {
        $recipient = $otherUser;
        $courseId = request('course_id');
        $course = null;

        if ($courseId) {
            $course = Course::find($courseId);
        }

        $unreadCount = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('user.messages.compose', compact('recipient', 'course', 'unreadCount'));
    }

    /**
     * Send a new message
     */
    public function send(Request $request)
    {
        // DEBUG: Log everything
        \Log::info('Send message request - ALL data:', $request->all());
        \Log::info('Send message request - course_id specifically:', ['course_id' => $request->course_id]);
        try {
            $request->validate([
                'receiver_id' => 'required|exists:users,id',
                'message' => 'required|string|max:5000',
                'course_id' => 'nullable|exists:courses,id'
            ]);

            $sender = Auth::user();
            $receiver = User::findOrFail($request->receiver_id);

            // Create message
            $message = Message::create([
                'sender_id' => $sender->id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'course_id' => $request->course_id,
                'is_read' => false
            ]);

            // Get course name if exists
            $courseName = null;
            if ($request->course_id) {
                $course = Course::find($request->course_id);
                $courseName = $course ? $course->title : null;
            }

            // Create notification for receiver
            Notification::create([
                'user_id' => $request->receiver_id,
                'title' => 'New Message from ' . $sender->name,
                'message' => substr($request->message, 0, 100) . (strlen($request->message) > 100 ? '...' : ''),
                'type' => 'message',
                'data' => [
                    'sender_id' => $sender->id,
                    'sender_name' => $sender->name,
                    'message_id' => $message->id,
                    'course_id' => $request->course_id,
                    'course_name' => $courseName
                ],
                'action_url' => route('messages.conversation', $sender->id),
                'action_text' => 'Reply',
                'is_read' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'data' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'created_at' => $message->created_at,
                    'is_read' => $message->is_read
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Message send error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send reply in conversation (AJAX)
     */
    public function sendReply(Request $request, User $otherUser)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:5000'
            ]);

            $sender = Auth::user();

            // Create message
            $message = Message::create([
                'sender_id' => $sender->id,
                'receiver_id' => $otherUser->id,
                'message' => $request->message,
                'course_id' => $request->course_id,
                'is_read' => false
            ]);

            // Get course name if exists
            $courseName = null;
            if ($request->course_id) {
                $course = Course::find($request->course_id);
                $courseName = $course ? $course->title : null;
            }

            // Create notification for receiver
            Notification::create([
                'user_id' => $otherUser->id,
                'title' => 'New Message from ' . $sender->name,
                'message' => substr($request->message, 0, 100) . (strlen($request->message) > 100 ? '...' : ''),
                'type' => 'message',
                'data' => [
                    'sender_id' => $sender->id,
                    'sender_name' => $sender->name,
                    'message_id' => $message->id,
                    'course_id' => $request->course_id,
                    'course_name' => $courseName,
                    'is_message' => true
                ],
                'action_url' => route('messages.conversation', $sender->id),
                'action_text' => 'Reply',
                'is_read' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'data' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'created_at' => $message->created_at,
                    'is_read' => $message->is_read
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Message send reply error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark message as read
     */
    public function markAsRead(Message $message)
    {
        try {
            if ($message->receiver_id != Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $message->update([
                'is_read' => true,
                'read_at' => now()
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Mark as read error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to mark as read'], 500);
        }
    }

    /**
     * Get new messages in conversation (for polling)
     */
    public function getNewMessages(User $otherUser, Request $request)
    {
        try {
            $user = Auth::user();
            $lastMessageId = $request->get('after', 0);

            // IMPORTANT: Only get messages with ID GREATER THAN lastMessageId
            $messages = Message::where(function ($query) use ($user, $otherUser) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $otherUser->id);
            })
                ->orWhere(function ($query) use ($user, $otherUser) {
                    $query->where('sender_id', $otherUser->id)
                        ->where('receiver_id', $user->id);
                })
                ->where('id', '>', $lastMessageId)  // This is critical!
                ->with(['sender'])
                ->orderBy('created_at', 'asc')
                ->get();

            // Mark received messages as read
            Message::where('sender_id', $otherUser->id)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);

            return response()->json($messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'created_at' => $message->created_at,
                    'is_read' => $message->is_read
                ];
            }));

        } catch (\Exception $e) {
            \Log::error('Get new messages error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get messages'], 500);
        }
    }

    // Send Message To Admin
    public function sendToAdmin(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
            'course_id' => 'required|exists:courses,id'
        ]);

        $user = Auth::user();
        $course = Course::find($request->course_id);

        // Create message
        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $request->admin_id,
            'message' => $request->message,
            'course_id' => $request->course_id,
            'is_read' => false
        ]);

        // Create notification for admin
        Notification::create([
            'user_id' => $request->admin_id,
            'title' => '📝 Re-enrollment Request',
            'message' => "{$user->name} wants to re-enroll in course '{$course->title}'",
            'type' => 'message',
            'data' => [
                'course_id' => $course->id,
                'course_title' => $course->title,
                'student_id' => $user->id,
                'student_name' => $user->name,
                'message_id' => $message->id
            ],
            'action_url' => route('messages.conversation', $user->id),
            'action_text' => 'Reply to Student',
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your request has been sent to the admin'
        ]);
    }

    /**
     * Delete a message
     */
    public function destroy(Message $message)
    {
        try {
            if ($message->sender_id != Auth::id() && $message->receiver_id != Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $message->delete();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Delete message error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete message'], 500);
        }
    }
}