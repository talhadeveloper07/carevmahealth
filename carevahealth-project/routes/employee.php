<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeProfile\ProfileController;

Route::get('/complete-profile', [AuthController::class, 'showCompleteProfileForm'])
    ->name('employee.completeProfile')
    ->middleware('signed');

Route::middleware(['auth', 'employee' ,'profile.complete'])->prefix('employee')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('employee.dashboard');
});

Route::prefix('employee/dashboard/profile')->name('employee.profile.')->group(function () {
    Route::get('/edit', [ProfileController::class, 'editProfile'])->name('edit');
    Route::post('/update', [ProfileController::class, 'updateProfile'])->name('update');
});