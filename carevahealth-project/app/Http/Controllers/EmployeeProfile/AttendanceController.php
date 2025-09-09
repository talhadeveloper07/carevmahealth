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
use App\Models\EmployeeClientSchedule;
use App\Models\EmployeeSalary;
use App\Models\Client;
use App\Events\Notifications;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function clockIn(Request $request)
    {
        try {
            $employee = Employee::where('user_id', auth()->id())->firstOrFail();
            $tzEmployee = $employee->timezone ?? config('app.timezone');
    
            // Employee local "today"
            $todayLocal = now($tzEmployee)->toDateString();
            $todayWeekday = strtolower(now($tzEmployee)->format('l')); // e.g. "monday"
    
            // Prevent duplicate clock-ins
            $attendance = Attendance::where('employee_id', $employee->id)
                ->where('date', $todayLocal)
                ->first();
    
            if ($attendance && $attendance->clock_in) {
                return back()->with('error', 'Already clocked in today.');
            }
    
            // --- Find client's shift for today ---
            $schedule = EmployeeClientSchedule::where('employee_id', $employee->id)
                ->where('weekday', $todayWeekday)
                ->where('enabled', true)
                ->first();
            
                
    
            if (!$schedule) {
                return back()->with('error', 'No scheduled shift found for today.');
            }
    
            // Assume employee has only one client for now
            $client = Client::findOrFail($schedule->client_id);
            $clientTz = $client->timezone ?? config('app.timezone');
    
            // --- Parse client shift times ---
            $scheduledStartClient = Carbon::parse($todayLocal . ' ' . $schedule->start_time, $clientTz);
            $scheduledEndClient   = Carbon::parse($todayLocal . ' ' . $schedule->end_time, $clientTz);
    
            // Convert to UTC
            $scheduledStartUtc = $scheduledStartClient->clone()->setTimezone('UTC');
            $scheduledEndUtc   = $scheduledEndClient->clone()->setTimezone('UTC');
    
            // Actual clock-in in UTC
            $clockInUtc = now('UTC');
    
            // --- Late calculation ---
            $lateMinutes = 0;
            if ($clockInUtc->gt($scheduledStartUtc)) {
                $lateMinutes = $scheduledStartUtc->diffInMinutes($clockInUtc);
            }
    
            // Convert allowed break hours into HH:MM:SS
            $hoursDecimal = $employee->break_allowed_hours;
            $hours = floor($hoursDecimal);
            $minutes = round(($hoursDecimal - $hours) * 60);
    
            if ($minutes === 60) {
                $hours += 1;
                $minutes = 0;
            }
    
            $breakTime = sprintf('%02d:%02d:%02d', $hours, $minutes, 0);
    
            // Save attendance
            Attendance::updateOrCreate(
                ['employee_id' => $employee->id, 'date' => $todayLocal],
                [
                    'client_id'   => $client->id,
                    'clock_in'    => $clockInUtc,
                    'break_limit' => $breakTime,
                    'late_minutes'=> $lateMinutes,
                ]
            );
    
            return back()->with('success', 'Clocked in successfully!');

            event(new Notifications([
                'id' => $employee->id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'email' => $employee->email
            ], 'EmployeeClockedIn'));

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
        $tzEmployee = $employee->timezone ?? config('app.timezone');
    
        // Employee's local "today"
        $todayLocal = now($tzEmployee)->toDateString();
        $todayWeekday = strtolower(now($tzEmployee)->format('l')); // monday, tuesday, etc.
    
        // Find today's attendance
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
            $endTime = $attendance->clock_out;
            $ongoingBreak->update(['end_time' => $endTime]);
    
            $start = Carbon::parse($ongoingBreak->start_time);
            $breakDuration = max(0, $start->diffInSeconds($endTime));
    
            $attendance->break_taken = intval($attendance->break_taken ?? 0) + $breakDuration;
        }
    
        // --- Fetch client shift from schedule ---
        $schedule = EmployeeClientSchedule::where('employee_id', $employee->id)
            ->where('weekday', $todayWeekday)
            ->where('enabled', true)
            ->first();
    
        if ($schedule) {
            $client = Client::findOrFail($schedule->client_id);
            $clientTz = $client->timezone ?? config('app.timezone');
    
            // Client shift times
            $scheduledStartClient = Carbon::parse($todayLocal . ' ' . $schedule->start_time, $clientTz);
            $scheduledEndClient   = Carbon::parse($todayLocal . ' ' . $schedule->end_time, $clientTz);
    
            $scheduledEndUtc = $scheduledEndClient->clone()->setTimezone('UTC');
    
            // ✅ Calculate total worked minutes (raw)
            $start = Carbon::parse($attendance->clock_in);
            $end   = Carbon::parse($attendance->clock_out);
            $totalMinutes = $start->diffInMinutes($end);
    
            // ✅ Subtract break_taken (convert seconds → minutes)
            $breakMinutes = intval(($attendance->break_taken ?? 0) / 60);
            $netMinutes = max(0, $totalMinutes - $breakMinutes);
    
            // ✅ Overtime (worked beyond scheduled end)
            $overtimeMinutes = 0;
            if ($end->gt($scheduledEndUtc)) {
                $overtimeMinutes = $scheduledEndUtc->diffInMinutes($end);
            }
    
            $attendance->total_minutes = $netMinutes;
            $attendance->overtime = $overtimeMinutes;


        } else {
            // Fallback if no schedule found
            $start = Carbon::parse($attendance->clock_in);
            $end   = Carbon::parse($attendance->clock_out);
            $attendance->total_minutes = $start->diffInMinutes($end);
        }
    
        // Keep the `date` in employee’s local timezone
        $attendance->date = $todayLocal;
    
        $attendance->save();

        event(new Notifications([
            'id' => $employee->id,
            'first_name' => $employee->first_name,
            'last_name' => $employee->last_name,
            'email' => $employee->email
        ], 'employeeclockedOut'));
    
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

        event(new Notifications([
            'id' => $attendance->id,
            'first_name' => $attendance->employee->first_name,
            'last_name' => $attendance->employee->last_name,
            'email' => $attendance->employee->email
        ], 'requestChangeTime'));
    
        return response()->json(['message' => 'Request submitted successfully.']);
    }
    
    

}