<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\User;
use App\Models\Department;
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
        
        // Get tasks assigned to the user
        $myTasksQuery = TaskAssignment::where('user_id', $user->id)->with(['task.creator']);
        
        // Apply filters for my tasks
        if ($request->status) {
            $myTasksQuery->where('status', $request->status);
        }
        
        $myTasks = $myTasksQuery->orderBy('created_at', 'desc')->paginate(10, ['*'], 'my_tasks');
        
        // Get tasks created by the user (only for managers and admins)
        $createdTasks = null;
        if ($user->role === 'manager' || $user->role === 'admin') {
            $createdTasksQuery = Task::where('created_by', $user->id)->with(['assignments', 'creator']);
            $createdTasks = $createdTasksQuery->orderBy('created_at', 'desc')->paginate(10, ['*'], 'created_tasks');
        }
        
        return view('tasks.index', compact('myTasks', 'createdTasks'));
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

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Only managers and admins can create tasks
        if (!in_array($user->role, ['manager', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        $departments = Department::all();
        $users = User::where('role', '!=', 'admin')->get();
        
        return view('tasks.create', compact('departments', 'users'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Only managers and admins can create tasks
        if (!in_array($user->role, ['manager', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:individual,group',
            'priority' => 'required|in:low,medium,high,urgent',
            'department_id' => 'nullable|exists:departments,id',
            'due_date' => 'nullable|date|after:today',
            'estimated_hours' => 'nullable|numeric|min:0',
            'assigned_users' => 'required|array|min:1',
            'assigned_users.*' => 'exists:users,id',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'priority' => $request->priority,
            'status' => 'pending',
            'created_by' => $user->id,
            'department_id' => $request->department_id,
            'due_date' => $request->due_date,
            'estimated_hours' => $request->estimated_hours,
        ]);

        // Create task assignments
        foreach ($request->assigned_users as $userId) {
            TaskAssignment::create([
                'task_id' => $task->id,
                'user_id' => $userId,
                'status' => 'assigned',
                'assigned_at' => now(),
                'assigned_by' => $user->id,
            ]);
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $user = Auth::user();
        
        // Only task creator, managers and admins can edit tasks
        if ($task->created_by !== $user->id && !in_array($user->role, ['manager', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        $departments = Department::all();
        $users = User::where('role', '!=', 'admin')->get();
        $assignedUsers = $task->assignments->pluck('user_id')->toArray();
        
        return view('tasks.edit', compact('task', 'departments', 'users', 'assignedUsers'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        $user = Auth::user();
        
        // Only task creator, managers and admins can update tasks
        if ($task->created_by !== $user->id && !in_array($user->role, ['manager', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:individual,group',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'department_id' => 'nullable|exists:departments,id',
            'due_date' => 'nullable|date',
            'estimated_hours' => 'nullable|numeric|min:0',
            'assigned_users' => 'required|array|min:1',
            'assigned_users.*' => 'exists:users,id',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'priority' => $request->priority,
            'status' => $request->status,
            'department_id' => $request->department_id,
            'due_date' => $request->due_date,
            'estimated_hours' => $request->estimated_hours,
        ]);

        // Update task assignments
        $currentAssignments = $task->assignments->pluck('user_id')->toArray();
        $newAssignments = $request->assigned_users;

        // Remove assignments that are no longer needed
        $toRemove = array_diff($currentAssignments, $newAssignments);
        if (!empty($toRemove)) {
            TaskAssignment::where('task_id', $task->id)
                ->whereIn('user_id', $toRemove)
                ->delete();
        }

        // Add new assignments
        $toAdd = array_diff($newAssignments, $currentAssignments);
        foreach ($toAdd as $userId) {
            TaskAssignment::create([
                'task_id' => $task->id,
                'user_id' => $userId,
                'status' => 'assigned',
                'assigned_at' => now(),
                'assigned_by' => $user->id,
            ]);
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $user = Auth::user();
        
        // Only task creator, managers and admins can delete tasks
        if ($task->created_by !== $user->id && !in_array($user->role, ['manager', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        // Delete related assignments first
        $task->assignments()->delete();
        
        // Delete the task
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
