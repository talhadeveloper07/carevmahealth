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
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/complete-profile/{employee}', [EmployeeController::class, 'showCompleteProfileForm'])->name('employee.complete-profile');
Route::post('/complete-profile/{employee}', [EmployeeController::class, 'submitCompleteProfile']);


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
    
});

require __DIR__.'/employee.php';