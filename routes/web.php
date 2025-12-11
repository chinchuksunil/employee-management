<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('login/{role?}', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'loginAction'])->name('login.submit');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::resource('employees', EmployeeController::class);

    Route::resource('users', UserController::class);

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
