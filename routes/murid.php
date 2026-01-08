<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Murid Routes
|--------------------------------------------------------------------------
|
| URL Prefix: /murid
| Name Prefix: murid.
| Middleware: auth, role:siswa
|
*/

Route::get('/dashboard', function () {
    return view('pages.murid.dashboard'); // <--- GANTI JADI VIEW
})->name('dashboard');

Route::get('/rapor', function() {
    return "Halaman Lihat Rapor";
})->name('rapor');

Route::get('/tagihan', function() {
    return "Halaman Tagihan SPP";
})->name('tagihan');