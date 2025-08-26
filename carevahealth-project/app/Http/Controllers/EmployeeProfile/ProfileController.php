<?php

namespace App\Http\Controllers\EmployeeProfile;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        // Use employee’s timezone to decide “today”
        $todayLocal = now($employee->timezone ?? config('app.timezone'))->toDateString();
    
        $attendanceToday = Attendance::where('employee_id', $employee->id)
            ->where('date', $todayLocal)   // 'date' is a DATE column
            ->first();
    
            return view('employee.dashboard.index',compact('employee', 'attendanceToday'));
        }

    public function editProfile()
    {
        $employee = Employee::where('user_id', Auth::id())->first();
        return view('employee.profile.index', compact('employee'));
    }

    // Profile Update
    public function updateProfile(Request $request)
    {
        $employee = Employee::where('user_id', Auth::id())->first();

        $employee->update($request->all());

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store(
                'employees/profile_pictures', // folder inside storage/app/public
                'public' // disk
            );
        
            $employee->profile_picture = $path;

            $employee->save();
        }
        // Mark profile completed after first update
        if (!$employee->profile_completed) {
            $employee->update(['profile_completed' => true]);
        }

        return redirect()->route('employee.profile.edit')->with('success', 'Profile updated successfully!');
    }

}
