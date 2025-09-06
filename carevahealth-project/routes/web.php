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
use App\Http\Controllers\Auth\OrgGoogleController;
use App\Http\Controllers\Admin\Client\ServiceController;
use App\Http\Controllers\Admin\Client\ContractTypeController;
use App\Http\Controllers\Admin\Client\AdminClientController;
use App\Http\Controllers\EmployeeClientScheduleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AdminDashboardController;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/complete-profile', [EmployeeController::class, 'showCompleteProfileForm'])->name('employee.completeProfile')->middleware('signed');;
Route::post('/complete-profile', [EmployeeController::class, 'submitCompleteProfile'])->name('employee.submitCompleteProfile');


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard',[AdminDashboardController::class,'index'])->name('admin.dashboard');
  
    // Employee Options Routes
    Route::resource('departments', DepartmentController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('employment-types', EmploymentTypeController::class);
    Route::resource('shift-types', ShiftTypeController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('employee-statuses', EmployeeStatusController::class);
    Route::resource('expertises', ExpertiseController::class);
    Route::resource('reporting-managers', ReportingManagerController::class);

    // Client Options Routes
    Route::resource('services', ServiceController::class);
    Route::resource('contracts', ContractTypeController::class);

    // Client Routes
    Route::get('clients',[AdminClientController::class,'index'])->name('all.clients');
    Route::get('add-client',[AdminClientController::class,'add_client'])->name('add.client');
    Route::post('insert-client',[AdminClientController::class,'insert_client'])->name('insert.client');
    Route::get('client/{id}/schedule',[AdminClientController::class,'client_schedule'])->name('client.schedule');
    Route::get('assign-employee',[AdminClientController::class,'assign_employee'])->name('client.assign.employee');
    Route::get('assign-client/{id}/details', [AdminClientController::class, 'get_client_details'])->name('client.details');
    Route::get('assign-employee/{id}/details', [AdminClientController::class, 'get_employee_details'])->name('employee.details');
    Route::post('assign-employee/schedules', [EmployeeClientScheduleController::class, 'store'])
    ->name('employee.schedules.store');
    Route::get('client/{id}/assign-employee',[AdminClientController::class,'assign_va'])->name('client.assigned.va');
    Route::get('client/{id}/profile',[AdminClientController::class,'client_profile'])->name('client.profile');
    Route::get('client/{id}/daily-work-report',[AdminClientController::class,'daily_report'])->name('daily.report');


    // Employee Routes
    Route::get('add-employee',[EmployeeController::class,'add_employee'])->name('add.employee');
    Route::post('insert-employee',[EmployeeController::class,'insert_employee'])->name('insert.employee');
    Route::get('add-employee',[EmployeeController::class,'add_employee'])->name('add.employee');
    Route::get('employees',[EmployeeController::class,'all_employees'])->name('all.employees');
    Route::get('edit-employee/profile/{id}',[EmployeeController::class,'edit_employee'])->name('edit.employee');
    Route::put('update-employee/{id}',[EmployeeController::class,'update_employee'])->name('update.employee');
    Route::delete('employees/{id}', [EmployeeController::class, 'delete_employee'])->name('delete.employee');
    
    // Attendance Route
    Route::get('attendance',[AdminAttendanceController::class,'index'])->name('admin.attendance');
    Route::get('attendance-requests', [AdminAttendanceController::class, 'attendance_changes_requests'])->name('admin.attendance.requests');
    Route::post('attendance-requests/approve', [AdminAttendanceController::class, 'approve'])->name('approve.attendance.request');
    Route::post('attendance-requests/reject', [AdminAttendanceController::class, 'reject'])->name('reject.attendance.request');


    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/all', [NotificationController::class, 'fetchAll'])->name('notifications.all');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/count', [NotificationController::class, 'count'])->name('notifications.count');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::post('/notifications/read', [NotificationController::class, 'readSingle'])->name('notifications.readSingle');

});

require __DIR__.'/employee.php';
require __DIR__.'/client.php';


// Google Auth Routes

Route::get('/google/connect', [OrgGoogleController::class, 'redirectToGoogle'])->name('google.connect');
Route::get('/google/callback', [OrgGoogleController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/auth/google/redirect', [OrgGoogleController::class, 'redirectToGoogleLogin'])->name('google.login');
Route::post('/google/disconnect', [OrgGoogleController::class, 'disconnectGoogle'])->name('google.disconnect')->middleware('auth'); 
