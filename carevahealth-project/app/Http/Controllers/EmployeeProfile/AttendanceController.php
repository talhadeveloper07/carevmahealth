<?php

namespace App\Http\Controllers\EmployeeProfile;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Attendance;
use App\Models\EmployeeBreak;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AttendanceChangeRequestMail;
use App\Models\AttendanceChangeRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function clockIn(Request $request)
    {
        try {
            $employee = Employee::where('user_id', auth()->id())->firstOrFail();
            $tz = $employee->timezone ?? config('app.timezone');
    
            // Employee's local "today"
            $todayLocal = now($tz)->toDateString();
    
            // Prevent duplicate clock-ins for today (employee's local date)
            $attendance = Attendance::where('employee_id', $employee->id)
                ->where('date', $todayLocal)
                ->first();
    
            if ($attendance && $attendance->clock_in) {
                return back()->with('error', 'Already clocked in today.');
            }
    
            // Convert allowed break hours into HH:MM:SS
            $hoursDecimal = $employee->break_allowed_hours; // e.g. 2, 0.5, 1.75
            $hours = floor($hoursDecimal);
            $minutes = round(($hoursDecimal - $hours) * 60);
    
            // Handle edge case if rounding → 60 minutes
            if ($minutes === 60) {
                $hours += 1;
                $minutes = 0;
            }
    
            $breakTime = sprintf('%02d:%02d:%02d', $hours, $minutes, 0);
    
            // Store in UTC, but attach local date
            Attendance::updateOrCreate(
                ['employee_id' => $employee->id, 'date' => $todayLocal],
                [
                    'break_limit' => $breakTime,
                    'clock_in'    => now('UTC'),
                ]
            );
    
            return back()->with('success', 'Clocked in successfully!');
        } catch (\Exception $e) {
            \Log::error('Clock-in failed: ' . $e->getMessage(), [
                'user_id' => $employee->id ?? null,
                'trace'   => $e->getTraceAsString(),
            ]);
    
            return back()->with('error', 'Something went wrong while clocking in. Please try again later.');
        }
    }
    


    public function clockOut(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $tz = $employee->timezone ?? config('app.timezone');
    
        // Employee's local "today"
        $todayLocal = now($tz)->toDateString();
    
        // Find today's attendance by employee's local date
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $todayLocal)
            ->firstOrFail();
    
        // Store clock_out in UTC
        $attendance->clock_out = now('UTC');
    
        // ✅ Handle unfinished break
        $ongoingBreak = $attendance->breaks()
            ->whereNull('end_time')
            ->latest()
            ->first();
    
        if ($ongoingBreak) {
            $endTime = $attendance->clock_out; // close break at clock_out time
            $ongoingBreak->update(['end_time' => $endTime]);
    
            $start = Carbon::parse($ongoingBreak->start_time);
            $breakDuration = max(0, $start->diffInSeconds($endTime));
    
            // Add to break_taken (stored in seconds)
            $attendance->break_taken = intval($attendance->break_taken ?? 0) + $breakDuration;
        }
    
        // ✅ Total worked minutes
        $start = Carbon::parse($attendance->clock_in);
        $end   = Carbon::parse($attendance->clock_out);
        $totalMinutes = $start->diffInMinutes($end);
    
        // ✅ Example: shift length fixed (replace with dynamic value per employee if needed)
        $shiftMinutes = 5;
        $overtimeMinutes = max(0, $totalMinutes - $shiftMinutes);
    
        $attendance->overtime = $overtimeMinutes;
        $attendance->total_minutes = $totalMinutes;
    
        // Keep the `date` in employee’s local timezone
        $attendance->date = $todayLocal;
    
        $attendance->save();
    
        return redirect()->back()->with('success', 'Clocked out successfully!');
    }

    public function startBreak(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
    
        // Use employee’s timezone for "today"
        $todayLocal = Carbon::now($employee->timezone ?? config('app.timezone'))->toDateString();
    
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $todayLocal)
            ->first();
    
        if (!$attendance) {
            return back()->with('error', 'You must clock in first.');
        }
    
        // Save break with employee’s timezone aware timestamp
        $attendance->breaks()->create([
            'notes' => $request->notes,
            'start_time' => Carbon::now($employee->timezone ?? config('app.timezone')),
        ]);
    
        return back()->with('success', 'Break started.');
    }
    
    public function endBreak(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
    
        $todayLocal = Carbon::now($employee->timezone ?? config('app.timezone'))->toDateString();
    
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $todayLocal)
            ->firstOrFail();
    
        $break = $attendance->breaks()
            ->whereNull('end_time')
            ->latest()
            ->first();
    
        if ($break) {
            $endTime = Carbon::now($employee->timezone ?? config('app.timezone'));
            $break->update(['end_time' => $endTime]);
    
            // ✅ Calculate duration safely in employee’s timezone
            $start = Carbon::parse($break->start_time, $employee->timezone ?? config('app.timezone'));
            $breakDuration = max(0, $start->diffInSeconds($endTime));
    
            // ✅ Add to break_taken
            $attendance->break_taken = intval($attendance->break_taken ?? 0) + $breakDuration;
            $attendance->save();
        }
    
        return back()->with('success', 'Break ended, resume work.');
    }

    public function requestChange(Request $request)
    {
        $attendance = Attendance::findOrFail($request->attendance_id);

        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'clock_in' => 'required|date_format:H:i',
            'clock_out' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    if (strtotime($value) <= strtotime($request->clock_in)) {
                        $fail('The clock out must be after the clock in.');
                    }
                },
            ],
            'reason' => 'required|string|max:255',
            'date' => [
                'required',
                Rule::unique('attendance_change_requests')
                    ->where(function ($query) use ($attendance, $request) {
                        return $query->where('employee_id', $attendance->employee_id)
                                    ->where('date', $request->date);
                    }),
            ],
        ]);

        // ✅ Save request in separate table
        $changeRequest = AttendanceChangeRequest::create([
            'attendance_id' => $attendance->id,
            'employee_id' => $attendance->employee_id,
            'date' => $attendance->date,
            'requested_clock_in' => $request->clock_in,
            'requested_clock_out' => $request->clock_out,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);
    
        // ✅ Get admin
        $admin = User::where('role', 'admin')->first();
    
        if ($admin) {
            // ✅ Use the correct Mailable
            Mail::to($admin->email)->send(new AttendanceChangeRequestMail($changeRequest));
        }
    
        return response()->json(['message' => 'Request submitted successfully.']);
    }
    
    

}