<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('admin',function(){
    return view('admin.dashboard.index');
<<<<<<< Updated upstream
});
=======

});


Route::prefix('admin')->group(function () {
    Route::get('departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');
    Route::get('departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
});

// Roles Routes

Route::get('roles', [RoleController::class, 'index']);
Route::post('roles', [RoleController::class, 'store']);
Route::get('roles/{role}', [RoleController::class, 'show']);
Route::put('roles/{role}', [RoleController::class, 'update']);
Route::patch('roles/{role}', [RoleController::class, 'update']);
Route::delete('roles/{role}', [RoleController::class, 'destroy']);

// Employment Types Routes

Route::get('employment-types', [EmploymentTypeController::class, 'index']);
Route::post('employment-types', [EmploymentTypeController::class, 'store']);
Route::get('employment-types/{employmentType}', [EmploymentTypeController::class, 'show']);
Route::put('employment-types/{employmentType}', [EmploymentTypeController::class, 'update']);
Route::patch('employment-types/{employmentType}', [EmploymentTypeController::class, 'update']);
Route::delete('employment-types/{employmentType}', [EmploymentTypeController::class, 'destroy']);

// Shift Types Routes
 

Route::get('shift-types', [ShiftTypeController::class, 'index']);
Route::post('shift-types', [ShiftTypeController::class, 'store']);
Route::get('shift-types/{shiftType}', [ShiftTypeController::class, 'show']);
Route::put('shift-types/{shiftType}', [ShiftTypeController::class, 'update']);
Route::patch('shift-types/{shiftType}', [ShiftTypeController::class, 'update']);
Route::delete('shift-types/{shiftType}', [ShiftTypeController::class, 'destroy']);


// Designations Routes

Route::get('designations', [DesignationController::class, 'index']);
Route::post('designations', [DesignationController::class, 'store']);
Route::get('designations/{designation}', [DesignationController::class, 'show']);
Route::put('designations/{designation}', [DesignationController::class, 'update']);
Route::patch('designations/{designation}', [DesignationController::class, 'update']);
Route::delete('designations/{designation}', [DesignationController::class, 'destroy']);

// Employee Statuses Routes

Route::get('employee-statuses', [EmployeeStatusController::class, 'index']);
Route::post('employee-statuses', [EmployeeStatusController::class, 'store']);
Route::get('employee-statuses/{employeeStatus}', [EmployeeStatusController::class, 'show']);
Route::put('employee-statuses/{employeeStatus}', [EmployeeStatusController::class, 'update']);
Route::patch('employee-statuses/{employeeStatus}', [EmployeeStatusController::class, 'update']);
Route::delete('employee-statuses/{employeeStatus}', [EmployeeStatusController::class, 'destroy']);

// Sources of Hire Routes

Route::get('sources-of-hire', [SourceOfHireController::class, 'index']);
Route::post('sources-of-hire', [SourceOfHireController::class, 'store']);
Route::get('sources-of-hire/{sourceOfHire}', [SourceOfHireController::class, 'show']);
Route::put('sources-of-hire/{sourceOfHire}', [SourceOfHireController::class, 'update']);
Route::patch('sources-of-hire/{sourceOfHire}', [SourceOfHireController::class, 'update']);
Route::delete('sources-of-hire/{sourceOfHire}', [SourceOfHireController::class, 'destroy']);

// Current Expertises Routes

Route::get('current-expertises', [CurrentExpertiseController::class, 'index']);
Route::post('current-expertises', [CurrentExpertiseController::class, 'store']);
Route::get('current-expertises/{currentExpertise}', [CurrentExpertiseController::class, 'show']);
Route::put('current-expertises/{currentExpertise}', [CurrentExpertiseController::class, 'update']);
Route::patch('current-expertises/{currentExpertise}', [CurrentExpertiseController::class, 'update']);
Route::delete('current-expertises/{currentExpertise}', [CurrentExpertiseController::class, 'destroy']);
>>>>>>> Stashed changes
