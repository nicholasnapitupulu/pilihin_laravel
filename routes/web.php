<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KampusController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdiKampusController;
use App\Http\Controllers\SuperAdminController;

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
    Route::get('/admin/jurusan', [JurusanController::class, 'admin_index'])->name('jurusan.admin_index');
    Route::post('/admin/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
    Route::delete('/admin/jurusan/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

    Route::get('/admin/kampus', [KampusController::class, 'admin_index'])->name('kampus.admin_index');
    Route::post('/admin/kampus', [KampusController::class, 'store'])->name('kampus.store');
    Route::delete('/admin/kampus/{id}', [KampusController::class, 'destroy'])->name('kampus.destroy');

    Route::get('/admin/prodi', [ProdiKampusController::class, 'index'])->name('prodi.index');
    Route::post('/admin/prodi/update', [ProdiKampusController::class, 'update'])->name('prodi.update');
});

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');
    Route::post('/user', [SuperAdminController::class, 'store'])->name('user.store');
    Route::delete('/user/{id}', [SuperAdminController::class, 'destroy'])->name('user.destroy');
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