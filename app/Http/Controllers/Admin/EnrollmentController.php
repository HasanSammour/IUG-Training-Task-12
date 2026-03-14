<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Notification;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['user', 'course']);
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('enrollment_id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('course', function($q) use ($request) {
                      $q->where('title', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('enrolled_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('enrolled_at', '<=', $request->date_to);
        }
        
        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $enrollments = $query->paginate($request->get('per_page', 20))->withQueryString();
        
        // Get statistics
        $stats = [
            'total' => Enrollment::count(),
            'active' => Enrollment::where('status', 'active')->count(),
            'completed' => Enrollment::where('status', 'completed')->count(),
            'pending' => Enrollment::where('status', 'pending')->count(),
            'cancelled' => Enrollment::where('status', 'cancelled')->count(),
            'revenue' => Enrollment::sum('amount_paid'),
            'average_progress' => round(Enrollment::avg('progress_percentage') ?? 0, 1),
        ];
        
        $statuses = ['pending', 'active', 'completed', 'cancelled'];
        
        return view('admin.enrollments.index', compact('enrollments', 'statuses', 'stats'));
    }
    
    public function create()
    {
        $students = User::role('student')->orderBy('name')->get();
        $courses = Course::where('is_active', true)->orderBy('title')->get();
        
        return view('admin.enrollments.create', compact('students', 'courses'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer,manual,free',
            'status' => 'required|in:pending,active,completed,cancelled',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'enrolled_at' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Check if already enrolled
        $existing = Enrollment::where('user_id', $request->user_id)
            ->where('course_id', $request->course_id)
            ->exists();

        if ($existing) {
            return back()->with('error', 'Student is already enrolled in this course.')->withInput();
        }

        // Generate unique enrollment ID
        $enrollmentId = 'ENR-' . strtoupper(uniqid());

        // For free payment, ensure amount is 0
        $amountPaid = $request->payment_method === 'free' ? 0 : $request->amount_paid;

        $enrollment = Enrollment::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'enrollment_id' => $enrollmentId,
            'amount_paid' => $amountPaid,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'progress_percentage' => $request->progress_percentage,
            'notes' => $request->notes,
            'enrolled_at' => $request->enrolled_at ?? now(),
            'completed_at' => $request->status === 'completed' ? now() : null,
        ]);

        // Update course total students count
        $enrollment->course->increment('total_students');

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment created successfully. ID: ' . $enrollmentId);
    }
    
    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['user', 'course']);
        return view('admin.enrollments.show', compact('enrollment'));
    }
    
    public function edit(Enrollment $enrollment)
    {
        $students = User::role('student')->orderBy('name')->get();
        $courses = Course::where('is_active', true)->orderBy('title')->get();
        
        return view('admin.enrollments.edit', compact('enrollment', 'students', 'courses'));
    }
    
    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer,manual,free',
            'status' => 'required|in:pending,active,completed,cancelled',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);
    
        $data = [
            'amount_paid' => $request->payment_method === 'free' ? 0 : $request->amount_paid,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'progress_percentage' => $request->progress_percentage,
            'notes' => $request->notes,
        ];
    
        if ($request->status === 'completed' && $enrollment->status !== 'completed') {
            $data['completed_at'] = now();
        } elseif ($request->status !== 'completed') {
            $data['completed_at'] = null;
        }
    
        // Handle status change for student count
        $oldStatus = $enrollment->status;
        $enrollment->update($data);
    
        // Update course student count if status changed
        if ($oldStatus != 'active' && $request->status == 'active') {
            $enrollment->course->increment('total_students');
        } elseif ($oldStatus == 'active' && $request->status != 'active') {
            $enrollment->course->decrement('total_students');
        }
    
        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment updated successfully.');
    }
    
    public function destroy(Enrollment $enrollment)
    {
        // Decrease course student count
        if ($enrollment->status == 'active' || $enrollment->status == 'completed') {
            $enrollment->course->decrement('total_students');
        }
        
        $enrollment->delete();
        
        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment deleted successfully.');
    }
    
    public function updateStatus(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'status' => 'required|in:pending,active,completed,cancelled',
        ]);
        
        $oldStatus = $enrollment->status;
        $enrollment->update([
            'status' => $request->status,
            'completed_at' => $request->status === 'completed' ? now() : null,
        ]);
        
        // Update course student count if status changed
        if ($oldStatus != 'active' && $request->status == 'active') {
            $enrollment->course->increment('total_students');
        } elseif ($oldStatus == 'active' && $request->status != 'active') {
            $enrollment->course->decrement('total_students');
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }
    
    public function updateProgress(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);
        
        $data = ['progress_percentage' => $request->progress];
        
        if ($request->progress == 100 && $enrollment->status != 'completed') {
            $data['status'] = 'completed';
            $data['completed_at'] = now();
        } elseif ($request->progress < 100 && $enrollment->status == 'pending') {
            $data['status'] = 'active';
        }
        
        $enrollment->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully',
            'progress' => $request->progress,
            'status' => $enrollment->fresh()->status
        ]);
    }

    public function approve(Enrollment $enrollment)
    {
        $enrollment->update(['status' => Enrollment::STATUS_ACTIVE]);

        Notification::create([
            'user_id' => $enrollment->user_id,
            'title' => '✅ Enrollment Approved',
            'message' => "Your enrollment in '{$enrollment->course->title}' has been approved! You can now access the course.",
            'type' => 'enrollment',
            'data' => ['enrollment_id' => $enrollment->id],
            'action_url' => route('courses.progress', $enrollment->id),
            'action_text' => 'Start Learning',
        ]);

        return back()->with('success', 'Enrollment approved successfully');
    }

    public function reject(Enrollment $enrollment)
    {
        $enrollment->update(['status' => Enrollment::STATUS_CANCELLED]);

        Notification::create([
            'user_id' => $enrollment->user_id,
            'title' => '❌ Enrollment Rejected',
            'message' => "Your enrollment in '{$enrollment->course->title}' was not approved. Please contact admin for details.",
            'type' => 'enrollment',
            'data' => ['enrollment_id' => $enrollment->id],
        ]);

        return back()->with('success', 'Enrollment rejected');
    }
    
    /**
     * Bulk actions for enrollments
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,complete,cancel,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:enrollments,id'
        ]);
        
        $count = 0;
        $errors = [];
        
        foreach ($request->ids as $id) {
            try {
                $enrollment = Enrollment::find($id);
                
                switch ($request->action) {
                    case 'activate':
                        if ($enrollment->status != 'active') {
                            $enrollment->update(['status' => 'active']);
                            $enrollment->course->increment('total_students');
                        }
                        break;
                        
                    case 'complete':
                        if ($enrollment->status != 'completed') {
                            $enrollment->update([
                                'status' => 'completed',
                                'progress_percentage' => 100,
                                'completed_at' => now()
                            ]);
                        }
                        break;
                        
                    case 'cancel':
                        if ($enrollment->status == 'active') {
                            $enrollment->course->decrement('total_students');
                        }
                        $enrollment->update(['status' => 'cancelled']);
                        break;
                        
                    case 'delete':
                        if ($enrollment->status == 'active' || $enrollment->status == 'completed') {
                            $enrollment->course->decrement('total_students');
                        }
                        $enrollment->delete();
                        break;
                }
                
                $count++;
                
            } catch (\Exception $e) {
                $errors[] = "Error processing enrollment ID: {$id}";
            }
        }
        
        $message = "{$count} enrollment(s) updated successfully.";
        if (!empty($errors)) {
            $message .= " " . implode('. ', $errors);
        }
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'count' => $count
        ]);
    }
}