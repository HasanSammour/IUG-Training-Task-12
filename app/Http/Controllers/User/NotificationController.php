<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get paginated notifications for display
        $notifications = $user->notifications()
            ->latest()
            ->paginate(20);
        
        // Calculate stats from ALL notifications (not just current page)
        $totalNotifications = $user->notifications()->count();
        $unreadCount = $user->notifications()->where('is_read', false)->count();
        $todayCount = $user->notifications()->whereDate('created_at', today())->count();
        $weekCount = $user->notifications()->where('created_at', '>=', now()->subDays(7))->count();
        
        // Get counts by type from ALL notifications
        $courseCount = $user->notifications()->where('type', 'course')->count();
        $systemCount = $user->notifications()->where('type', 'system')->count();
        $enrollmentCount = $user->notifications()->where('type', 'enrollment')->count();
        $progressCount = $user->notifications()->where('type', 'progress')->count();
        $achievementCount = $user->notifications()->where('type', 'achievement')->count();
        $reminderCount = $user->notifications()->where('type', 'reminder')->count();
        $messageTypeCount = $user->notifications()->where('type', 'message')->count();
        
        // Get unread messages count
        $unreadMessages = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();
        
        return view('user.notifications', compact(
            'notifications',
            'totalNotifications',
            'unreadCount', 
            'todayCount',
            'weekCount',
            'unreadMessages',
            'courseCount',
            'systemCount',
            'enrollmentCount',
            'progressCount',
            'achievementCount',
            'reminderCount',
            'messageTypeCount'
        ));
    }
    
    public function markAsRead(Request $request, $id)
    {
        try {
            $notification = Notification::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            $notification->update(['is_read' => true]);
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return back()->with('success', 'Notification marked as read.');
            
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to mark as read'], 500);
            }
            return back()->with('error', 'Failed to mark as read.');
        }
    }
    
    public function markAllAsRead(Request $request)
    {
        try {
            Auth::user()->notifications()
                ->where('is_read', false)
                ->update(['is_read' => true]);
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return back()->with('success', 'All notifications marked as read.');
            
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to mark all as read'], 500);
            }
            return back()->with('error', 'Failed to mark all as read.');
        }
    }
    
    public function destroy(Request $request, $id)
    {
        try {
            $notification = Notification::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            $notification->delete();
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return back()->with('success', 'Notification deleted.');
            
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to delete'], 500);
            }
            return back()->with('error', 'Failed to delete.');
        }
    }
    
    public function clearAll(Request $request)
    {
        try {
            Auth::user()->notifications()->delete();
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return back()->with('success', 'All notifications cleared.');
            
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to clear'], 500);
            }
            return back()->with('error', 'Failed to clear.');
        }
    }
    
    // API functions
    public function unreadCount()
    {
        $count = Auth::user()->notifications()
            ->where('is_read', false)
            ->count();
            
        return response()->json(['count' => $count]);
    }
    
    public function latest()
    {
        $notifications = Auth::user()->notifications()
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();
            
        return response()->json($notifications);
    }
}