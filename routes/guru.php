<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:guru'])->group(function () {
    
    // [BARU] Tambahkan ini agar redirect dari web.php berhasil
    Route::get('/dashboard', function() {
        return view('pages.guru.dashboard'); // Pastikan file view ini ada
    })->name('dashboard'); 

    Route::get('/jadwal', function() { 
        return "Jadwal Mengajar"; 
    })->name('jadwal');
    
    Route::get('/input-nilai', function() { 
        return "Form Input Nilai"; 
    })->name('nilai.create');

});