<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\EmploymentType;
use App\Models\ShiftType;
use App\Models\Designation;
use App\Models\EmployeeStatus;
use App\Models\Expertise;
use App\Models\ReportingManager;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompleteProfileMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function add_employee(Request $request)
    {
        $departments       = Department::all();
        $roles             = Role::all();
        $employmentTypes   = EmploymentType::all();
        $shiftTypes        = ShiftType::all();
        $designations      = Designation::all();
        $employeeStatuses  = EmployeeStatus::all();
        $expertises        = Expertise::all();
        $reportingManagers = ReportingManager::all();
        $users             = User::all();
    
        return view('admin.employee.add', compact(
            'departments',
            'roles',
            'employmentTypes',
            'shiftTypes',
            'designations',
            'employeeStatuses',
            'expertises',
            'reportingManagers',
            'users'
        ));
    }

public function insert_employee(Request $request)
{
    $request->validate([
        'first_name'        => 'required|string|max:100',
        'last_name'         => 'required|string|max:100',
        'email'             => 'required|email|unique:employees,email',
        'department'        => 'required|integer',
        'role'              => 'required|integer',
        'employee_type'     => 'required|integer',
        'designation'       => 'required|integer',
        'shift_type'        => 'required|integer',
        'salary_pkr'        => 'nullable|numeric',
        'salary_usd'        => 'nullable|numeric',
        'joining_date'      => 'nullable|date',
        'regularisation_date'=> 'nullable|date',
        'birth_date'        => 'nullable|date',
        'age'               => 'nullable|integer',
        'gender'            => 'nullable|string',
        'marital_status'    => 'nullable|string',
        'notes'             => 'nullable|string',
        'employee_image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'documents.*'       => 'nullable|file|max:5120',
    ]);

    DB::beginTransaction();

    try {
        // ✅ Save employee
        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->password = Hash::make($request->password);
        $employee->department_id = $request->department;
        $employee->role_id = $request->role;
        $employee->employment_type_id = $request->employee_type;
        $employee->designation_id = $request->designation;
        $employee->shift_type_id = $request->shift_type;
        $employee->employee_status_id = $request->employee_status;
        $employee->salary_pkr = $request->salary_pkr;
        $employee->salary_usd = $request->salary_usd;
        $employee->source_of_hire = $request->source_of_hire;
        $employee->date_of_joining = $request->joining_date;
        $employee->date_of_regularisation = $request->regularisation_date;
        $employee->expertise_id = $request->current_expertise;
        $employee->break_allowed_hours = $request->breaks;
        $employee->reporting_manager_id = $request->reporting_manager;
        $employee->gender = $request->gender;
        $employee->marital_status = $request->marital_status;
        $employee->age = $request->age;
        $employee->date_of_birth = $request->birth_date;
        $employee->about_me_notes = $request->notes;

        // ✅ Upload profile image
        if ($request->hasFile('employee_image')) {
            $path = $request->file('employee_image')->store('employees/images', 'public');
            $employee->employee_image = $path;
        }

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(12)),
        ]);

        $employee->user_id = $user->id;
        $employee->save();

        // ✅ Upload documents (Dropzone)
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('employees/documents', 'public');

                $employee->documents()->create([
                    'file_path' => $path,
                ]);
            }
        }
        
        $temporaryUrl = URL::temporarySignedRoute(
            'employee.completeProfile',
            now()->addHours(24), // 24 hours expiry
            ['email' => $user->email, 'token' => $token]
        );

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        Mail::to($user->email)->send(new CompleteProfileMail($employee, $temporaryUrl));

        DB::commit();

        return redirect()->back()->with('success', 'Employee added successfully!');
    } catch (\Exception $e) {
        DB::rollBack();

        // Log error for debugging
        Log::error('Employee Insert Error: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()->with('error', 'Something went wrong! Please try again.');
    }
}


    public function showCompleteProfileForm(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record) {
            return redirect()->route('login')->with('error', 'Invalid or expired link.');
        }

        // Validate token
        if (!Hash::check($token, $record->token)) {
            return redirect()->route('login')->with('error', 'Invalid or expired token.');
        }

        $employee = Employee::where('email', $email)->firstOrFail();

        return view('complete_profile.index', compact('employee'));
    }

    public function submitCompleteProfile(Request $request, Employee $employee)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
            'gender' => 'required',
            'date_of_birth' => 'required|date',
        ]);

        // Update user password
        $user = $employee->user;
        $user->password = Hash::make($request->password);
        $user->save();

        // Update employee profile
        $employee->update([
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'marital_status' => $request->marital_status,
            'about_me_notes' => $request->about_me_notes,
        ]);

        return redirect()->route('login')->with('success', 'Profile completed successfully. You can now login.');
    }
}