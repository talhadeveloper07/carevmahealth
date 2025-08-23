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
}