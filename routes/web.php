<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // Wajib tambah baris ini di atas

Route::get('/', [HomeController::class, 'index']);
Route::get('/tentang', function () {
    return view('tentang');
});
Route::get('/kampus', [HomeController::class, 'kampus']);