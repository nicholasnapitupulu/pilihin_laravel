<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KampusController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TesController;
use App\Http\Controllers\AdminController;

// ROUTE GUEST
Route::get('/', [HomeController::class, 'index']);
Route::get('/kampus', [KampusController::class, 'index']);
Route::get('/jurusan', [JurusanController::class, 'index']);
Route::get('/jurusan/{id}/roadmap', [JurusanController::class, 'roadmap']);
Route::get('/tentang', function () {return view('tentang');});

// ROUTE USER
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/update-photo', [DashboardController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::get('/tes', [TesController::class, 'index'])->name('tes.index');
    Route::post('/tes/proses', [TesController::class, 'proses'])->name('tes.proses');
});

// ROUTE ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// ROUTE AUTH
Route::get('/login', [AuthController::class, 'showAuthPage'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Fitur Logout
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Hasil Pengerjaan
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::post('/tes/proses', [TesController::class, 'proses'])->name('tes.proses');
    Route::get('/tes/hasil/{id}', [TesController::class, 'tampilkanHasil'])->name('tes.hasil');
});