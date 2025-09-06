<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeClientSchedule;
use App\Models\Employee;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class EmployeeClientScheduleController extends Controller
{

    public function store(Request $request)
    {
        // ✅ Base validation
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'employees.*.employee_id' => 'required|exists:employees,id',
        ]);
    
        $employees = $request->input('employees', []);
        $clientId  = $request->client_id;
    
        $client = Client::findOrFail($clientId);
        $tz     = $client->timezone ?? config('app.timezone'); // fallback
    
        DB::beginTransaction();
    
        try {
            foreach ($employees as $employee) {
                $employeeId = $employee['employee_id'];
    
                foreach ($employee['weekdays'] as $day => $data) {
                    if (!isset($data['enabled'])) {
                        continue; // skip unchecked days
                    }
    
                    // 🔍 Validation: prevent duplicate schedule for same client + employee + weekday
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
    
                    // ✅ Convert start & end time from client TZ → UTC
                    $startTime = !empty($data['start'])
                        ? Carbon::parse($data['start'], $tz)->setTimezone('UTC')->format('H:i:s')
                        : null;
    
                    $endTime = !empty($data['end'])
                        ? Carbon::parse($data['end'], $tz)->setTimezone('UTC')->format('H:i:s')
                        : null;
    
                    EmployeeClientSchedule::create([
                        'employee_id' => $employeeId,
                        'client_id'   => $clientId,
                        'weekday'     => $day,
                        'start_time'  => $startTime,
                        'end_time'    => $endTime,
                        'no_of_hours' => $data['total_hours'] ?? null,
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
    
}
