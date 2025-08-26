<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Yajra\DataTables\Facades\DataTables;

class AdminAttendanceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $attendances = Attendance::with(['employee', 'breaks'])->select('attendances.*');

            return DataTables::eloquent($attendances)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->employee->first_name.' '.$row->employee->last_name ?? 'N/A';
                })
                ->addColumn('date', function ($row) {
                    return $row->date ? \Carbon\Carbon::parse($row->date)->format('Y-m-d') : '-';
                })
                ->addColumn('clock_in', function ($row) {
                    return $row->clock_in ? \Carbon\Carbon::parse($row->clock_in)->format('H:i') : '-';
                })
                ->addColumn('clock_out', function ($row) {
                    return $row->clock_out ? \Carbon\Carbon::parse($row->clock_out)->format('H:i') : '-';
                })
                ->addColumn('breaks', function ($row) {
                    return $row->breaks->count();
                })
                ->addColumn('break_taken', function ($row) {
                    $time = $row->break_taken ?? '00:00:00';
                
                    // Split HH:MM:SS into parts
                    [$hours, $minutes, $seconds] = explode(':', $time);
                
                    // Make sure numeric
                    $hours   = (int)$hours;
                    $minutes = (int)$minutes;
                    $seconds = (int)$seconds;
                
                    // Format back to HH:MM:SS
                    return sprintf('%d:%02d hrs', $hours, $minutes);

                })
                ->addColumn('overtime', function ($row) {
                    if ($row->overtime > 0) {
                        $hours   = floor($row->overtime / 60);
                        $minutes = $row->overtime % 60;
                        return sprintf('%d:%02d hrs', $hours, $minutes);
                    }
                    return '-';
                })
                ->addColumn('worked_hours', function ($row) {
                    if ($row->clock_in && !$row->clock_out) {
                        // Still working
                        return 'Running...';
                    }
                
                    $workedDuration = '-';
                
                    if ($row->clock_in && $row->clock_out) {
                        $start = \Carbon\Carbon::parse($row->clock_in);
                        $end   = \Carbon\Carbon::parse($row->clock_out);
                
                        // ✅ Ensure it's an integer
                        $minutes = (int) $start->diffInMinutes($end);
                
                        if ($minutes < 60) {
                            $workedDuration = $minutes . ' mins';
                        } else {
                            $workedDuration = sprintf('%d:%02d hrs', floor($minutes / 60), $minutes % 60);
                        }
                    }
                
                    return $workedDuration;
                })
                ->rawColumns(['employee', 'worked_hours'])
                ->make(true);
        }

        return view('admin.attendance.index');
    }
}
