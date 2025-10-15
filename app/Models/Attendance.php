<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'clock_in',
        'clock_out',
        'clock_in_time',
        'clock_out_time',
        'overtime_start',
        'overtime_end',
        'status',
        'work_type',
        'notes',
        'work_summary',
        'clock_in_location',
        'clock_out_location',
        'clock_in_ip',
        'clock_out_ip',
        'photo_clock_in',
        'photo_clock_out',
        'latitude_clock_in',
        'longitude_clock_in',
        'latitude_clock_out',
        'longitude_clock_out',
        'total_hours',
        'overtime_hours',
    ];

    protected $casts = [
        'date' => 'date',
        'clock_in' => 'datetime:H:i',
        'clock_out' => 'datetime:H:i',
        'clock_in_time' => 'datetime',
        'clock_out_time' => 'datetime',
        'overtime_start' => 'datetime:H:i',
        'overtime_end' => 'datetime:H:i',
        'total_hours' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
        'latitude_clock_in' => 'decimal:8',
        'longitude_clock_in' => 'decimal:8',
        'latitude_clock_out' => 'decimal:8',
        'longitude_clock_out' => 'decimal:8',
    ];

    /**
     * Get the user that owns the attendance.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate total working hours.
     */
    public function calculateTotalHours()
    {
        if ($this->clock_in && $this->clock_out) {
            $clockIn = Carbon::parse($this->clock_in);
            $clockOut = Carbon::parse($this->clock_out);
            return $clockOut->diffInHours($clockIn, true);
        }
        return 0;
    }

    /**
     * Calculate overtime hours.
     */
    public function calculateOvertimeHours()
    {
        if ($this->overtime_start && $this->overtime_end) {
            $overtimeStart = Carbon::parse($this->overtime_start);
            $overtimeEnd = Carbon::parse($this->overtime_end);
            return $overtimeEnd->diffInHours($overtimeStart, true);
        }
        return 0;
    }

    /**
     * Check if the attendance is late.
     */
    public function isLate()
    {
        return $this->status === 'late';
    }

    /**
     * Check if the attendance is present.
     */
    public function isPresent()
    {
        return in_array($this->status, ['present', 'late']);
    }
}