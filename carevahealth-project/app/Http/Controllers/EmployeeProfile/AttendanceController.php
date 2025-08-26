<?php

namespace App\Http\Controllers\EmployeeProfile;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Attendance;
use App\Models\EmployeeBreak;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function clockIn(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $today = Carbon::today();

        // Prevent duplicate clock-ins
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        if ($attendance && $attendance->clock_in) {
            return back()->with('error', 'Already clocked in today.');
        }

        $hoursDecimal = $employee->break_allowed_hours; // e.g. 2 OR 0.5 OR 1.75

        $hours = floor($hoursDecimal); // whole hours
        $minutes = ($hoursDecimal - $hours) * 60; // remaining minutes
        
        $breakTime = sprintf('%02d:%02d:%02d', $hours, $minutes, 0);
        
        Attendance::updateOrCreate(
            ['employee_id' => $employee->id, 'date' => $today],
            [
                'break_limit' => $breakTime,
                'clock_in'   => now(),
            ]
        );
        return back()->with('success', 'Clocked in successfully!');
    }

    public function clockOut(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->firstOrFail();

        $attendance->clock_out = now();

        // ✅ Total worked minutes (from clock_in to clock_out, INCLUDING breaks)
        $start = \Carbon\Carbon::parse($attendance->clock_in);
        $end   = \Carbon\Carbon::parse($attendance->clock_out);

        $totalMinutes = $start->diffInMinutes($end);

        // ✅ Calculate overtime
        $shiftMinutes = 2 * 60; // 9 hours
        $overtimeMinutes = $totalMinutes > $shiftMinutes ? $totalMinutes - $shiftMinutes : 0;

        // ✅ Save overtime
        $attendance->overtime = $overtimeMinutes;
        $attendance->total_minutes = $totalMinutes;

        // ✅ Calculate total break taken
        $totalBreakSeconds = $attendance->breaks->sum(function($break) {
            if ($break->end_time && $break->start_time) {
                return \Carbon\Carbon::parse($break->end_time)
                    ->diffInSeconds(\Carbon\Carbon::parse($break->start_time));
            }
            return 0;
        });

        // Convert seconds to minutes (or store seconds if you prefer)
        $attendance->break_taken = floor($totalBreakSeconds / 60); // minutes
        
        $attendance->save();

        return response()->json([
            'message' => 'Clocked out successfully',
            'total_minutes' => $totalMinutes,
            'overtime' => $overtimeMinutes
        ]);
    }

    
    public function startBreak(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        if (!$attendance) {
            return back()->with('error', 'You must clock in first.');
        }

        // Save break
        $attendance->breaks()->create([
            'notes' => $request->notes,
            'start_time' => now(),
        ]);

        return back()->with('success', 'Break started.');
    }

    public function endBreak(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        $break = $attendance->breaks()->whereNull('end_time')->latest()->first();

        if ($break) {
            $break->update(['end_time' => now()]);
    
            // Calculate break duration in seconds
            $breakDuration = Carbon::parse($break->start_time)->diffInSeconds(now());
    
            // Add to existing break_taken (if multiple breaks)
            $attendance->break_taken = ($attendance->break_taken ?? 0) + $breakDuration;
            $attendance->save();
        }

        return back()->with('success', 'Break ended, resume work.');
    }

}