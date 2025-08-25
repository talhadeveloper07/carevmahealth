<?php

namespace App\Http\Controllers\EmployeeProfile;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('employee.dashboard.index');
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

        // Mark profile completed after first update
        if (!$employee->profile_completed) {
            $employee->update(['profile_completed' => true]);
        }

        return redirect()->route('employee.profile.edit')->with('success', 'Profile updated successfully!');
    }

}
