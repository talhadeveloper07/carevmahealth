<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeProfile\ProfileController;
use App\Http\Controllers\EmployeeProfile\AttendanceController;

// Route::get('/complete-profile', [AuthController::class, 'showCompleteProfileForm'])
//     ->name('employee.completeProfile')
//     ->middleware('signed');

Route::middleware(['auth', 'employee' ,'profile.complete'])->prefix('employee')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('employee.dashboard');

    Route::post('/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clockIn');
    Route::post('/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clockOut');   
    Route::post('/attendance/start-break', [AttendanceController::class, 'startBreak'])->name('attendance.startBreak');
    Route::post('/attendance/end-break', [AttendanceController::class, 'endBreak'])->name('attendance.endBreak');

    Route::get('/my-attendance',[ProfileController::class,'employee_attendance'])->name('my.attendance'); 
    
    Route::post('/attendance/request-change', [AttendanceController::class, 'requestChange'])
    ->name('attendance.requestChange');

    Route::get('settings',[ProfileController::class,'settings'])->name('employee.setting');
   
});

Route::prefix('employee/dashboard/profile')->name('employee.profile.')->group(function () {
    Route::get('/edit', [ProfileController::class, 'editProfile'])->name('edit');
    Route::post('/update', [ProfileController::class, 'updateProfile'])->name('update');
});