<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\TaskAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Show the user profile.
     */
    public function show()
    {
        $user = User::with('department')->find(Auth::id());
        
        // Calculate monthly statistics
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
        
        $attendances = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get();
            
        $monthlyStats = [
            'present' => $attendances->where('status', 'present')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'tasks' => TaskAssignment::where('user_id', $user->id)
                ->where('status', 'completed')
                ->whereMonth('created_at', Carbon::now()->month)
                ->count()
        ];
        
        return view('profile.show', compact('user', 'monthlyStats'));
    }

    /**
     * Show the form for editing profile.
     */
    public function edit()
    {
        $user = User::with('department')->find(Auth::id());
        $departments = Department::orderBy('name')->get();
        
        return view('profile.edit', compact('user', 'departments'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
        
        // Only admin can update these fields
        if ($user->role === 'admin') {
            $validationRules['department_id'] = 'nullable|exists:departments,id';
            $validationRules['role'] = 'required|in:employee,manager,admin';
            $validationRules['hire_date'] = 'nullable|date';
        }

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
        ];
        
        // Add admin-only fields
        if ($user->role === 'admin') {
            $updateData['department_id'] = $request->department_id;
            $updateData['role'] = $request->role;
            $updateData['hire_date'] = $request->hire_date;
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $updateData['avatar'] = $avatarPath;
        }

        User::where('id', $user->id)->update($updateData);

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::id());

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed'], 422);
        }

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Current password is incorrect'], 422);
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => true, 'message' => 'Password updated successfully!']);
    }
}
