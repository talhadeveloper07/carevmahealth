<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard',function(){
        return view('admin.dashboard.index');
    });

    // Employee Routes
    Route::get('add-employee',[EmployeeController::class,'add_employee'])->name('add.employee');
});
