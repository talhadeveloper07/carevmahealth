<?php

namespace App\Http\Controllers\EmployeeProfile;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class CompleteProfileController extends Controller
{
    public function welcome(Request $request)
    {
        return view('employee.after_register.index');
    }

    public function complete_profile(Request $request)
    {
        $employeeId = $request->employee;
        $emp = Employee::where('id',$employeeId)->first();
        
        return view('employee.after_register.complete_profile',compact('emp'));
    }

    public function update(Request $request)
    {
        $employee = Employee::where('id', $request->employee_id)->firstOrFail();
    
        // ✅ Full form submit (multi-step)
        $validated = $request->validate([
            'first_name'         => 'required|string|max:100',
            'last_name'          => 'required|string|max:100',
            'email'              => 'required|email|unique:employees,email,' . $employee->id,
            'gender'             => 'required|in:male,female,other',
            'marital_status'     => 'required|in:single,married',
            'age'                => 'required|integer|min:18|max:100',
            'date_of_birth'      => 'required|date|before:today',
            'about_me_notes'     => 'nullable|string|max:500',
            'profile_picture'    => 'nullable|image|mimes:jpg,jpeg,png|max:800',
            'upload_documents'   => 'required|array|min:1',
            'upload_documents.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
    
        $data = $request->only($employee->getFillable());
    
        // Profile picture
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('employees/profile_pictures', 'public');
            $data['profile_picture'] = Storage::url($path);
        }
    
        // Documents
        if ($request->hasFile('upload_documents')) {
            $paths = [];
            foreach ($request->file('upload_documents') as $file) {
                $paths[] = Storage::url($file->store('employees/documents', 'public'));
            }
            $data['upload_documents'] = json_encode($paths);
        }

        $hashedPassword = Hash::make($request->password);
        $data['password'] = $hashedPassword;
    
        $employee->update($data);

        if ($employee->user_id) {
            $user = User::find($employee->user_id);
            if ($user) {
                $user->password = $hashedPassword;
                $user->email = $request->email; // keep emails in sync
                $user->save();
            }
        }

        $this->checkProfileCompletion($employee);
    
        if ($employee->profile_completed) {
            return redirect()->route('employee.completed', ['employee' => $employee->id]);
        }
    
        return redirect()->back()->with('error', 'Please complete all required fields before proceeding.');
    }
    
    
    
    private function checkProfileCompletion(Employee $employee)
    {
        $requiredFields = [
            'first_name', 'last_name', 'email',
            'date_of_birth', 'age', 'gender', 'marital_status',
            'upload_documents'
        ];
    
        $isComplete = true;
        foreach ($requiredFields as $field) {
            if (empty($employee->$field)) {
                $isComplete = false;
                break;
            }
        }
    
        $employee->profile_completed = $isComplete ? 1 : 0;
        $employee->save();
    }
    
    public function profile_completed($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        return view('employee.after_register.profile_done', compact('employee'));
    }
    public function autoLogin($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);

        // ✅ Log in the related user without password
        Auth::login($employee->user);

        return redirect()->route('employee.dashboard');
    }
}
