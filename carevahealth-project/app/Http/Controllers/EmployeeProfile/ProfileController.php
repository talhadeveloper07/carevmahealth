<?php

namespace App\Http\Controllers\EmployeeProfile;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Events\Notifications;


class ProfileController extends Controller
{
    public function index()
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
    
        // Employee's timezone (fallback to app timezone if null)
        $tz = $employee->timezone ?? config('app.timezone');
    
        // Local date according to employee’s timezone
        $todayLocal = now($tz)->toDateString();
    
        // Fetch today's attendance (date column stores employee's local date)
        $attendanceToday = Attendance::where('employee_id', $employee->id)
            ->where('date', $todayLocal)
            ->first();
    
        // Convert times into employee’s local timezone for display
        if ($attendanceToday) {
            if ($attendanceToday->clock_in) {
                $attendanceToday->clock_in_local = $attendanceToday->clock_in->copy()->timezone($tz);
            }
            if ($attendanceToday->clock_out) {
                $attendanceToday->clock_out_local = $attendanceToday->clock_out->copy()->timezone($tz);
            }
        }
    
        return view('employee.dashboard.index', compact('employee', 'attendanceToday'));
    }
    

    public function editProfile()
    {
        $employee = Employee::where('user_id', Auth::id())->first();
        return view('employee.profile.index', compact('employee'));
    }

    // Profile Update
    // public function updateProfile(Request $request)
    // {
    //     $employee = Employee::where('user_id', Auth::id())->first();

    //     $employee->update($request->all());

    //     if ($request->hasFile('profile_picture')) {
    //         $path = $request->file('profile_picture')->store(
    //             'employees/profile_pictures', // folder inside storage/app/public
    //             'public' // disk
    //         );
        
    //         $employee->profile_picture = $path;

    //         $employee->save();
    //     }
    //     // Mark profile completed after first update
    //     if (!$employee->profile_completed) {
    //         $employee->update(['profile_completed' => true]);
    //     }

    //     event(new Notifications([
    //         'id' => $employee->id,
    //         'first_name' => $employee->first_name,
    //         'last_name' => $employee->last_name,
    //         'email' => $employee->email,
    //         'profile_picture' => $employee->profile_picture
    //     ], 'ProfileUpdated'));

    //     return redirect()->route('employee.profile.edit')->with('success', 'Profile updated successfully!');
    // }

    public function updateProfile(Request $request)
    {
        $employee = Employee::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'field' => 'required|string',
        ]);

        $field = $request->field;

        // ✅ Handle upload_documents separately
        if ($field === 'upload_documents' && $request->hasFile('value')) {
            $path = $request->file('value')->store("employees/documents/{$employee->id}", 'public');
        
            // Get old documents (already cast to array if model has $casts)
            $docs = $employee->upload_documents ?? [];
        
            // Ensure it's always an array
            if (!is_array($docs)) {
                $docs = json_decode($docs, true) ?? [];
            }
        
            // Add new document
            $docs[] = $path;
        
            // Save back to DB (no json_encode needed if $casts is set)
            $employee->upload_documents = $docs;
            $employee->save();
        
            return response()->json([
                'success' => true,
                'value'   => asset('storage/' . $path),
            ]);
        }
        

        // ✅ Handle profile picture
        if ($field === 'profile_picture' && $request->hasFile('value')) {
            $path = $request->file('value')->store("employees/profile_pictures/{$employee->id}", 'public');
            $employee->update(['profile_picture' => $path]);

            return response()->json([
                'success' => true,
                'value'   => asset('storage/' . $path),
            ]);
        }

        // ✅ Default update for other fields
        if (!\Schema::hasColumn('employees', $field)) {
            return response()->json(['success' => false, 'message' => 'Invalid field'], 422);
        }

        $employee->update([$field => $request->value]);

        return response()->json(['success' => true]);
    }

    public function delete_document(Request $request)
    {
        $employee = Employee::where('user_id', Auth::id())->firstOrFail();

        $index = $request->index;
        $path = $request->path;

        $docs = $employee->upload_documents ?? [];
        if (!is_array($docs)) {
            $docs = json_decode($docs, true) ?? [];
        }

        // Remove by value
        $docs = array_filter($docs, function ($doc) use ($path) {
            return $doc !== $path;
        });

        $employee->upload_documents = array_values($docs); // reindex
        $employee->save();

        // Optionally delete file from storage
        if (\Storage::disk('public')->exists($path)) {
            \Storage::disk('public')->delete($path);
        }

        return response()->json(['success' => true]);
    }


    
    public function employee_attendance(Request $request)
    {
        if ($request->ajax()) {
            $employee = Employee::where('user_id', auth()->id())->firstOrFail();
            
            $query = Attendance::with(['employee', 'breaks'])
            ->where('employee_id', $employee->id);

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('date', [$request->from_date, $request->to_date]);
            } elseif ($request->filled('from_date')) {
                $query->whereDate('date', '>=', $request->from_date);
            } elseif ($request->filled('to_date')) {
                $query->whereDate('date', '<=', $request->to_date);
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->employee->first_name.' '.$row->employee->last_name ?? 'N/A';
                })
                ->addColumn('date', function ($row) {
                    if (!$row->date) return '-';
                    return Carbon::parse($row->date)->format('Y-m-d');
                })
                ->addColumn('clock_in', function ($row) {
                    if (!$row->clock_in) return '-';
                    $tz = $row->employee->timezone ?? config('app.timezone');
                    return Carbon::parse($row->clock_in)->timezone($tz)->format('h:i A');
                })
                ->addColumn('clock_out', function ($row) {
                    if (!$row->clock_out) return '-';
                    $tz = $row->employee->timezone ?? config('app.timezone');
                    return Carbon::parse($row->clock_out)->timezone($tz)->format('h:i A');
                })
                
                ->addColumn('breaks', function ($row) {
                    return $row->breaks->count();
                })
                // ->addColumn('break_taken', function ($row) {
                //     $seconds = max($row->break_taken ?? 0, 0);
                //     $hours = floor($seconds / 3600);
                //     $minutes = floor(($seconds % 3600) / 60);
                
                //     if ($hours > 0 && $minutes > 0) {
                //         return "{$hours} hrs {$minutes} mins";
                //     } elseif ($hours > 0) {
                //         return "{$hours} hrs";
                //     } elseif ($minutes > 0) {
                //         return "{$minutes} mins";
                //     } else {
                //         return "0 mins";
                //     }
                // })
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
                ->addColumn('actions', function ($row) {
                    return '<button class="btn btn-sm btn-warning request-change" 
                        data-id="'.$row->id.'"
                        data-date="'.\Carbon\Carbon::parse($row->date)->format('Y-m-d').'"
                        data-clock_in="'.$row->clock_in.'"
                        data-clock_out="'.$row->clock_out.'">
                        Request Change
                        </button>';
                })
                ->rawColumns(['employee', 'worked_hours','actions'])
                ->make(true);
        }
        return view('employee.attendance.index');
    }

    public function settings(Request $request)
    {
        return view('employee.setting.index');
    }

}
