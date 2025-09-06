<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 🔹 Total counts
        $clientsCount = Client::count();
        $employeesCount = Employee::count();

        // 🔹 Last 30 days ka range
        $last30Days = Carbon::now()->subDays(30);

        // 🔹 Clients added in last 30 days
        $newClientsLast30 = Client::where('created_at', '>=', $last30Days)->count();

        // 🔹 Employees added in last 30 days
        $newEmployeesLast30 = Employee::where('created_at', '>=', $last30Days)->count();

        return view('admin.dashboard.index', compact(
            'clientsCount',
            'employeesCount',
            'newClientsLast30',
            'newEmployeesLast30'
        ));
    }

    // 🔹 Attendance Stats (Ajax ke liye)
    public function getAttendanceStats()
    {
        $today = Carbon::today();

        // Aaj check-in (clock_in hai, clock_out NULL hai)
        $checkedIn = Attendance::whereDate('date', $today)
            ->whereNotNull('clock_in')
            ->whereNull('clock_out')
            ->count();

        // Aaj check-out (clock_in + clock_out dono filled hain)
        $checkedOut = Attendance::whereDate('date', $today)
            ->whereNotNull('clock_in')
            ->whereNotNull('clock_out')
            ->count();

        return response()->json([
            'checkedIn' => $checkedIn,
            'checkedOut' => $checkedOut,
        ]);
    }
}