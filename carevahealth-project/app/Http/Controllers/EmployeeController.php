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
use App\Events\Notifications;

use DataTables;
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
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:employees,email',
            'department' => 'required|integer',
            'role' => 'required|integer',
            'employee_type' => 'required|integer',
            'designation' => 'required|integer',
            'shift_type' => 'required|integer',
            'employee_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'documents.*' => 'nullable|file|max:5120',
            'breaks' => 'required',
        ]);
    
        DB::beginTransaction();
    
        // Remove try/catch temporarily
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
        $employee->salary_pkr = $request->salary_pkr;
        $employee->salary_usd = $request->salary_usd;
        $employee->date_of_joining = $request->joining_date;
        $employee->break_allowed_hours = $request->breaks;
        $employee->date_of_regularisation = $request->regularisation_date;
    
        if ($request->hasFile('employee_image')) {
            $employee->employee_image = $request->file('employee_image')->store('employees/images', 'public');
        }
    
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(12)),
        ]);
    
        $employee->user_id = $user->id;
        $employee->save();
    
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $employee->documents()->create([
                    'file_path' => $file->store('employees/documents', 'public'),
                ]);
            }
        }
    
        $token = Str::random(64);
    
        $temporaryUrl = URL::temporarySignedRoute(
            'employee.completeProfile',
            now()->addMinutes(5),
            ['email' => $user->email, 'token' => $token]
        );
    
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $name = $employee->first_name.' '.$employee->last_name;

        event(new Notifications([
            'id' => $employee->id,
            'name' => $name,
            'email' => $employee->email
        ], 'UserRegistered'));
    
        Mail::to($user->email)->send(new CompleteProfileMail($employee, $temporaryUrl));
    
        DB::commit();
    
        return redirect()->back()->with('success', 'Employee added successfully!');
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
        $temporaryUrl = $request->fullUrl();

        return view('complete_profile.index', compact(['employee','temporaryUrl']));
    }

    public function submitCompleteProfile(Request $request)
    {
         
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired link.');
        }

        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $employee = Employee::where('id', $request->employee_id)->first();

        // Update user password
        $user = $employee->user;
        $user->password = Hash::make($request->password);
        $user->save();

        // Update employee profile
        $employee->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Profile completed successfully. You can now login.');
    }

    public function all_employees(Request $request)
    {
        if ($request->ajax()) {
            $employees = Employee::with([
                'department',
                'role',
                'designation',
                'reportingManager',
                'shiftType',
                'employeeStatus',
                'expertise'
            ]);
    
            // Apply status filter
            if ($request->status) {
                $employees->where('employee_status_id', $request->status);
            }
    
            return DataTables::of($employees->get())
                ->addColumn('employee_info', function($e) {
                    $profilePic = $e->profile_picture 
                        ? asset('storage/' . $e->profile_picture) 
                        : asset('assets/img/avatars/1.png'); // fallback if no image
                    
                    $fullName = $e->first_name . ' ' . $e->last_name;
                
                    // Determine online/offline status
                    $isOnline = $e->user->last_seen_at && $e->user->last_seen_at->gt(now()->subMinutes(5));
                    $statusColor = $isOnline ? 'bg-success' : 'bg-secondary';
                    $statusTitle = $isOnline ? 'Online' : 'Offline';

                    return '
                        <div class="d-flex align-items-center">
                            <div class="position-relative me-2">
                                <img src="' . $profilePic . '" 
                                    class="rounded-circle" 
                                    width="40" height="40" 
                                    style="object-fit:cover;" />
                                <span class="position-absolute bottom-0 end-0 p-1 rounded-circle ' . $statusColor . '" 
                                    title="' . $statusTitle . '" 
                                    style="width:12px; height:12px; border:2px solid #fff;"></span>
                            </div>
                            <span>' . e($fullName) . '</span>
                        </div>
                    ';
                })
                ->addColumn('department', fn($e) => $e->department->name ?? '-')
                ->addColumn('role', fn($e) => $e->role->name ?? '-')
                ->addColumn('designation', fn($e) => $e->designation->name ?? '-')
                ->addColumn('reporting_manager', fn($e) => $e->reportingManager->name ?? '-')
                ->addColumn('shift_type', fn($e) => $e->shiftType->name ?? '-')
                ->addColumn('status', fn($e) => $e->employeeStatus->name ?? '-')
                ->addColumn('expertise', fn($e) => $e->expertise->name ?? '-')
                ->addColumn('actions', fn($e) => '<a href="'. route('edit.employee', $e->id) .'" class="btn btn-sm btn-primary">Edit</a>')
                ->rawColumns(['actions','employee_info'])
                ->make(true);
        }

        $statuses = EmployeeStatus::all();
    
        return view('admin.employee.index',compact('statuses'));
    }

    public function edit_employee($id)
    {
        $employee = Employee::findOrFail($id);

        return view('admin.employee.edit', [
            'employee' => $employee,
            'departments' => Department::all(),
            'roles' => Role::all(),
            'employmentTypes' => EmploymentType::all(),
            'designations' => Designation::all(),
            'shiftTypes' => ShiftType::all(),
            'employeeStatuses' => EmployeeStatus::all(),
            'expertises' => Expertise::all(),
            'reportingManagers' => ReportingManager::all(),
        ]);
    }

    public function update_employee(Request $request)
    {
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:employees,email,' . $request->employee_id,
        'department' => 'required|exists:departments,id',
        'role'       => 'required|exists:roles,id',
        'designation'=> 'required|exists:designations,id',
        'employee_type' => 'required|exists:employment_types,id',
        'shift_type'    => 'required|exists:shift_types,id',
        'employee_status' => 'required|exists:employee_statuses,id',
        'joining_date'   => 'required|date',
        'timezone' => 'nullable'
        // Add other validation rules as needed
    ]);

    // Find the employee
    $employee = Employee::findOrFail($request->id);

    // Update employee data
    $employee->update([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'department_id' => $request->department,
        'role_id'       => $request->role,
        'designation_id'=> $request->designation,
        'employment_type_id' => $request->employee_type,
        'shift_type_id' => $request->shift_type,
        'employee_status_id' => $request->employee_status,
        'salary_pkr'  => $request->salary_pkr,
        'salary_usd'  => $request->salary_usd,
        'source_of_hire' => $request->source_of_hire,
        'date_of_joining' => $request->joining_date,
        'date_of_regularisation' => $request->regularisation_date,
        'expertise_id' => $request->current_expertise,
        'reporting_manager_id' => $request->reporting_manager,
        'gender' => $request->gender,
        'marital_status' => $request->marital_status,
        'age' => $request->age,
        'date_of_birth' => $request->birth_date,
        'about_me_notes' => $request->notes,
        'break_allowed_hours' => $request->breaks,
        'timezone' => $request->timezone ?? null,

        // Add other fields as needed
    ]);

    // Handle file uploads if needed (documents, profile picture)
    // Example:
    // if ($request->hasFile('profile_picture')) {
    //     $file = $request->file('profile_picture');
    //     $path = $file->store('employees', 'public');
    //     $employee->profile_picture = $path;
    //     $employee->save();
    // }

    event(new Notifications([
        'id' => $employee->id,
        'name' => $employee->name,
        'email' => $employee->email
    ], 'UserRegistered'));

    return redirect()->route('edit.employee', $employee->id)
                     ->with('success', 'Employee updated successfully.');
    }

}