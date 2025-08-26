<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Employee\DepartmentController;
use App\Http\Controllers\Employee\RoleController;
use App\Http\Controllers\Employee\EmploymentTypeController;
use App\Http\Controllers\Employee\ShiftTypeController;
use App\Http\Controllers\Employee\DesignationController;
use App\Http\Controllers\Employee\EmployeeStatusController;
use App\Http\Controllers\Employee\ExpertiseController;
use App\Http\Controllers\Employee\ReportingManagerController;
use App\Http\Controllers\Admin\AdminAttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/complete-profile', [EmployeeController::class, 'showCompleteProfileForm'])->name('employee.completeProfile')->middleware('signed');;
Route::post('/complete-profile', [EmployeeController::class, 'submitCompleteProfile'])->name('employee.submitCompleteProfile');


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard',function(){
        return view('admin.dashboard.index');
    });
  
   Route::resource('departments', DepartmentController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('employment-types', EmploymentTypeController::class);
    Route::resource('shift-types', ShiftTypeController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('employee-statuses', EmployeeStatusController::class);
    Route::resource('expertises', ExpertiseController::class);
    Route::resource('reporting-managers', ReportingManagerController::class);

    // Employee Routes
    Route::get('add-employee',[EmployeeController::class,'add_employee'])->name('add.employee');
    Route::post('insert-employee',[EmployeeController::class,'insert_employee'])->name('insert.employee');
    Route::get('add-employee',[EmployeeController::class,'add_employee'])->name('add.employee');
    Route::get('employees',[EmployeeController::class,'all_employees'])->name('all.employees');
    Route::get('edit-employee/profile/{id}',[EmployeeController::class,'edit_employee'])->name('edit.employee');
    Route::put('update-employee/{id}',[EmployeeController::class,'update_employee'])->name('update.employee');
    
    // Attendance Route
    Route::get('attendance',[AdminAttendanceController::class,'index'])->name('admin.attendance');
});

require __DIR__.'/employee.php';