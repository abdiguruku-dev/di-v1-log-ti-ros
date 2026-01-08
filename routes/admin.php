<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\MuridController;

// Group Middleware: Harus Login
Route::middleware(['auth'])->group(function () {

    // 1. Dashboard
    Route::middleware(['role:super-admin|staff-tu|guru|bendahara'])
         ->get('/dashboard', function () { 
             return view('pages.admin.dashboard'); 
         })
         ->name('dashboard');

    // 2. Menu Keuangan
    Route::middleware(['can:terima-pembayaran'])
         ->prefix('keuangan')
         ->name('keuangan.')
         ->group(function() {
             Route::get('/bayar', function() { return "Halaman Kasir"; })->name('bayar');
         });

    // 3. Menu Super Admin (Manajemen User)
    Route::middleware(['role:super-admin'])
         ->resource('users', UserController::class);
         Route::resource('murid', MuridController::class); // <--- CUKUP TULIS 'UserController' SAJA
});