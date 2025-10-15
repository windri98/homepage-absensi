<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Admin and managers can see all tasks
        if ($user->role === 'manager' || $user->role === 'admin') {
            $query = TaskAssignment::with(['task', 'user']);
            
            // Apply filters
            if ($request->status) {
                $query->where('status', $request->status);
            }
            
            $tasks = $query->orderBy('created_at', 'desc')->paginate(10);
        } else {
            // Employees only see their own tasks
            $query = TaskAssignment::where('user_id', $user->id)->with('task');
            
            if ($request->status) {
                $query->where('status', $request->status);
            }
            
            $tasks = $query->orderBy('created_at', 'desc')->paginate(10);
        }
        
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        $user = Auth::user();
        
        // Check if user can view this task
        $assignment = TaskAssignment::where('task_id', $task->id)
            ->where('user_id', $user->id)
            ->first();
            
        if (!$assignment && $user->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $task->load(['assignments.user', 'creator']);
        
        return view('tasks.show', compact('task', 'assignment'));
    }

    /**
     * Update task assignment status.
     */
    public function updateStatus(Request $request, TaskAssignment $assignment)
    {
        $user = Auth::user();
        
        // Only assigned user can update their own status
        if ($assignment->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:assigned,in_progress,completed',
            'notes' => 'nullable|string|max:1000',
        ]);

        $assignment->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'completed_at' => $request->status === 'completed' ? now() : null,
        ]);

        return back()->with('success', 'Task status updated successfully!');
    }
}
