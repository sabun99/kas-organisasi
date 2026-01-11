<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Auth (Pastikan file ada di resources/views/pages/login.blade.php)
Route::get('/login', function () { 
    return view('pages.login'); 
})->name('login');

Route::get('/register', function () { 
    return view('pages.register'); 
})->name('register');
// Halaman Dashboard (Buat file di resources/views/pages/dashboard.blade.php)
Route::get('/dashboard', function () { 
    return view('pages.dashboard'); 
})->name('dashboard');
Route::get('/history', function () { 
    return view('pages.history'); 
})->name('history');
Route::get('/transaksi', function () { 
    return view('pages.transaksi'); 
})->name('transaksi');