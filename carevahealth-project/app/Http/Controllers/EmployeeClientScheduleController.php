<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeClientSchedule;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\Client;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class EmployeeClientScheduleController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'employees.*.employee_id' => 'required|exists:employees,id',
            'repeat' => 'boolean',
            'enabled' => 'boolean',
        ]);
    
        $employees = $request->input('employees', []);
        $clientId  = $request->client_id;
    
        $client = Client::findOrFail($clientId);
        $tz     = $client->timezone ?? config('app.timezone'); 
    
        DB::beginTransaction();
    
        try {
            foreach ($employees as $employee) {
                $employeeId = $employee['employee_id'];
    
                foreach ($employee['weekdays'] as $day => $data) {
                    if (!isset($data['enabled'])) {
                        continue; // skip unchecked days
                    }
    
                    $exists = EmployeeClientSchedule::where('client_id', $clientId)
                        ->where('employee_id', $employeeId)
                        ->where('weekday', $day)
                        ->exists();
    
                    if ($exists) {
                        DB::rollBack();
                        return redirect()->back()
                            ->withErrors([
                                "error" => "Schedule for {$day} already exists for this employee and client."
                            ])
                            ->withInput();
                    }
    
                    $startTime = !empty($data['start'])
                        ? Carbon::parse($data['start'], $tz)->format('H:i:s')
                        : null;
    
                    $endTime = !empty($data['end'])
                        ? Carbon::parse($data['end'], $tz)->format('H:i:s')
                        : null;
    
                    EmployeeClientSchedule::create([
                        'enabled' => $data['enabled'] ?? false,
                        'employee_id' => $employeeId,
                        'client_id'   => $clientId,
                        'weekday'     => $day,
                        'start_time'  => $startTime,
                        'end_time'    => $endTime,
                        'no_of_hours' => $data['total_hours'] ?? null,
                        'repeat' => $data['repeat'] ?? false
                    ]);
                }
            }
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Schedules assigned successfully.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'no_of_hours' => 'nullable|numeric|min:0'
        ]);

        $schedule = EmployeeClientSchedule::findOrFail($request->id);

        $client = Client::findOrFail($schedule->client_id);
        $tz     = $client->timezone ?? config('app.timezone');

        $schedule->start_time  = Carbon::parse($request->start_time, $tz)
            ->format('H:i:s');

        $schedule->end_time    = Carbon::parse($request->end_time, $tz)
            ->format('H:i:s');

        $schedule->no_of_hours = $request->no_of_hours;

        $schedule->save();

        return redirect()->back()->with('success', 'Schedule updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $schedule = EmployeeClientSchedule::findOrFail($id);
            $schedule->delete();

            return redirect()->back()->with('success', 'Schedule deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete schedule: ' . $e->getMessage()]);
        }
    }


    public function generate(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'client_id'   => 'required|exists:clients,id',
            'month'       => 'required|date_format:Y-m'
        ]);
    
        $employeeId = $request->employee_id;
        $clientId   = $request->client_id;
        $start      = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
        $end        = $start->copy()->endOfMonth();
    
        // Check attendance
        $attendance = Attendance::where('employee_id', $employeeId)
            ->whereBetween('date', [$start, $end])
            ->get();
    
        if ($attendance->isEmpty()) {
            return response()->json([
                'error' => 'No attendance found for this employee in selected month.'
            ], 422);
        }
    
        // Calculate hours from attendance
        $totalMinutes   = $attendance->sum('total_minutes');
        $totalOvertime  = $attendance->sum('overtime'); // assuming minutes
        $totalHours     = round(($totalMinutes + $totalOvertime) / 60, 2);
    
        // Calculate salary
        $employee = Employee::findOrFail($employeeId);
        $client = Client::findOrFail($clientId);
        $salaryAmount = $totalHours * $client->per_hour_charges;
    
        // Store in salaries table (update if already exists)
        $salary = EmployeeSalary::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'client_id'   => $clientId,
                'period_start'=> $start,
                'period_end'  => $end,
            ],
            [
                'total_hours'   => $totalHours,
                'salary_amount' => $salaryAmount,
            ]
        );
    
        return response()->json([
            'total_hours'   => $salary->total_hours,
            'salary_amount' => $salary->salary_amount,
        ]);
    }
    

    
}
