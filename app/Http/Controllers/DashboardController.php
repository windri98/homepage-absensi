<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Task;
use App\Models\TaskAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{

    /**
     * Show the dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Get today's attendance
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        // Get this month's attendance stats
        $thisMonth = Carbon::now()->startOfMonth();
        $monthlyAttendance = Attendance::where('user_id', $user->id)
            ->where('date', '>=', $thisMonth)
            ->get();

        $monthlyStats = [
            'present' => $monthlyAttendance->where('status', 'present')->count(),
            'late' => $monthlyAttendance->where('status', 'late')->count(),
            'absent' => $monthlyAttendance->where('status', 'absent')->count(),
            'tasks' => TaskAssignment::where('user_id', $user->id)
                ->where('status', 'completed')
                ->whereMonth('created_at', Carbon::now()->month)
                ->count()
        ];

        // Get pending tasks
        $pendingTasks = TaskAssignment::where('user_id', $user->id)
            ->whereIn('status', ['assigned', 'in_progress'])
            ->with('task')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'todayAttendance',
            'monthlyStats',
            'pendingTasks'
        ));
    }
}
