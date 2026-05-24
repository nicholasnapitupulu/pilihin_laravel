<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KampusController;
use App\Http\Controllers\JurusanController; // Tambahkan ini

Route::get('/', [HomeController::class, 'index']);

Route::get('/tentang', function () {
    return view('tentang');
});

Route::get('/kampus', [KampusController::class, 'index']);

// Tambahkan atau ubah route jurusan menjadi seperti ini:
Route::get('/jurusan', [JurusanController::class, 'index']);

// Route untuk halaman Roadmap Karir berdasarkan ID Jurusan
Route::get('/jurusan/{id}/roadmap', [JurusanController::class, 'roadmap']);