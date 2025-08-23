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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('admin',function(){
    return view('admin.dashboard.index');
});

Route::prefix('admin')->group(function () {

    Route::resource('departments', DepartmentController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('employment-types', EmploymentTypeController::class);
    Route::resource('shift-types', ShiftTypeController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('employee-statuses', EmployeeStatusController::class);
    Route::resource('expertises', ExpertiseController::class);
    Route::resource('reporting-managers', ReportingManagerController::class);

});

