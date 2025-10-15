<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{

    /**
     * Show clock in page.
     */
    public function showClockIn()
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        return view('attendance.clock-in', compact('todayAttendance'));
    }

    /**
     * Show clock out page.
     */
    public function showClockOut()
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        return view('attendance.clock-out', compact('todayAttendance'));
    }

    /**
     * Show overtime page.
     */
    public function showOvertime()
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        return view('attendance.overtime', compact('attendance'));
    }

    /**
     * Show QR scan page.
     */
    public function showQrScan()
    {
        return view('attendance.qr-scan');
    }

    /**
     * Process clock in.
     */
    public function clockIn(Request $request)
    {
        $request->validate([
            'work_type' => 'required|in:office,remote,field',
            'notes' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'location_address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();

        // Check if already clocked in today
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($existingAttendance && $existingAttendance->clock_in_time) {
            return back()->with('error', 'You have already clocked in today!');
        }

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('attendance/clock-in', 'public');
        }

        $attendance = Attendance::updateOrCreate(
            [
                'user_id' => $user->id,
                'date' => $today,
            ],
            [
                'clock_in_time' => $now,
                'work_type' => $request->work_type,
                'notes' => $request->notes,
                'photo_clock_in' => $photoPath,
                'latitude_clock_in' => $request->latitude,
                'longitude_clock_in' => $request->longitude,
                'clock_in_location' => $request->location_address,
                'clock_in_ip' => $request->ip(),
                'status' => $this->determineStatus($now),
            ]
        );

        return redirect()->route('dashboard')->with('success', 'Clock in successful!');
    }

    /**
     * Process clock out.
     */
    public function clockOut(Request $request)
    {
        $request->validate([
            'work_summary' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$attendance || !$attendance->clock_in_time) {
            return back()->with('error', 'You need to clock in first!');
        }

        if ($attendance->clock_out_time) {
            return back()->with('error', 'You have already clocked out today!');
        }

        $clockInTime = $attendance->clock_in_time;
        $totalHours = $now->diffInHours($clockInTime, true);

        $attendance->update([
            'clock_out_time' => $now,
            'work_summary' => $request->work_summary,
            'notes' => $request->notes ? $attendance->notes . "\n" . $request->notes : $attendance->notes,
            'clock_out_ip' => $request->ip(),
            'total_hours' => $totalHours,
        ]);

        return redirect()->route('dashboard')->with('success', 'Clock out successful!');
    }

    /**
     * Process overtime.
     */
    public function overtime(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan clock in!',
            ], 400);
        }

        if ($request->type === 'start') {
            $attendance->update([
                'overtime_start' => $now->format('H:i:s'),
            ]);
            $message = 'Overtime mulai!';
        } else {
            if (!$attendance->overtime_start) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum memulai overtime!',
                ], 400);
            }

            $overtimeStart = Carbon::parse($attendance->overtime_start);
            $overtimeHours = $now->diffInHours($overtimeStart, true);

            $attendance->update([
                'overtime_end' => $now->format('H:i:s'),
                'overtime_hours' => $overtimeHours,
            ]);
            $message = 'Overtime selesai!';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'time' => $now->format('H:i'),
        ]);
    }

    /**
     * Show attendance history.
     */
    public function history()
    {
        $user = Auth::user();
        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(30);

        return view('attendance.history', compact('attendances'));
    }

    /**
     * Show leave request form.
     */
    public function showLeaveRequest()
    {
        return view('attendance.leave');
    }

    /**
     * Determine attendance status based on clock in time.
     */
    private function determineStatus(Carbon $clockInTime)
    {
        $workStartTime = Carbon::today()->setTime(8, 0); // 08:00
        
        if ($clockInTime->greaterThan($workStartTime)) {
            return 'late';
        }
        
        return 'present';
    }
}
