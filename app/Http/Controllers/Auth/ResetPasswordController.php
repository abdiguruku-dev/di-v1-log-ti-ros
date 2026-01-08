<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | Controller ini bertugas menampilkan form ganti password
    | dan memproses penggantian password ke database.
    |
    */

    // 1. Tampilkan Form Reset (Menangkap Email & No HP dari Link)
    public function showResetForm(Request $request, $token = null)
    {
        // Kita kirimkan token, email, DAN no_hp (jika ada) ke view
        // Pastikan view mengarah ke 'auth.reset' sesuai lokasi file Anda
        return view('auth.reset')->with([
            'token' => $token, 
            'email' => $request->email,
            'no_hp' => $request->query('no_hp') // Menangkap parameter ?no_hp=... dari link
        ]);
    }

    // 2. Proses Simpan Password Baru
    public function reset(Request $request)
    {
        // Validasi Input
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Trik: Cek user dulu tanpa menghanguskan token
        // Agar kita bisa cek "Password Lama" tanpa error "Token Invalid"
        $userCheck = Password::broker()->getUser($request->only('email'));

        if (!$userCheck) {
             return back()->withErrors(['email' => __('passwords.user')]);
        }

        // Mulai proses reset password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                
                // --- LOGIKA CEK PASSWORD LAMA ---
                // Jika password baru sama persis dengan password lama di database
                if (Hash::check($password, $user->password)) {
                    throw ValidationException::withMessages([
                        'password' => ['Kata sandi yang Anda masukkan sudah pernah digunakan sebelumnya, ganti dengan kata sandi yang lain.']
                    ]);
                }
                // -------------------------------

                // Simpan Password Baru (Hash)
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        // Jika Berhasil Reset
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        // Jika Gagal (Misal token expired)
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}