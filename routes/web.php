<?php

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\MuridController;

/*
|--------------------------------------------------------------------------
| ROUTES ERP SYSTEM
|--------------------------------------------------------------------------
*/

// 1. Root -> Redirect ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 3. Google OAuth
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

// 4. Dashboard (Area Privat)
Route::middleware(['auth'])->group(function () { // <--- BUKA GROUP
    
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */ // <--- BISIKAN AJAIB (PHPDoc)
        $user = Auth::user();

        // 1. Super Admin & Bendahara -> Dashboard Admin (Tetap yang canggih)
    if ($user->hasRole(['super-admin', 'bendahara'])) {
        return redirect()->route('admin.dashboard');
    }

    // 2. Staff TU -> Dashboard Karyawan (Tampilan sederhana di atas)
    if ($user->hasRole('staff-tu')) {
        // Kita arahkan ke route baru khusus staff
        return view('pages.staff.dashboard'); 
    }

    // 3. Guru -> Dashboard Guru
    if ($user->hasRole('guru')) {
        return redirect()->route('guru.dashboard'); 
    }

    // 4. Murid -> Dashboard Murid
    if ($user->hasRole('murid')) {
        return redirect()->route('murid.dashboard');
    }
    
    // 5. Orang Tua (Jika nanti ada role ini)
    if ($user->hasRole('wali-murid')) {
         return view('pages.ortu.dashboard');
    }

    return abort(403, 'Anda tidak memiliki akses role yang valid.');

})->name('dashboard');

}); // <--- TUTUP GROUP DI SINI (PENTING!)


// --- FITUR LUPA PASSWORD (PUBLIC AREA) --- //

Route::get('lupa-sandi', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('lupa-sandi/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('atur-ulang-sandi/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('atur-ulang-sandi', [ResetPasswordController::class, 'reset'])
    ->name('password.update');