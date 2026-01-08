<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Pegawai; // PENTING: Kita panggil Model Pegawai
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    // Method Sakti untuk menangani Email ATAU WhatsApp
    public function sendResetLinkEmail(Request $request)
    {
        // 1. Ambil input dari form
        $input = $request->input('login_id');

        // 2. Cek apakah ini Email atau No HP?
        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'no_hp';

        // --- SKENARIO 1: JIKA USER INPUT EMAIL ---
        // (Logika: Cek langsung ke tabel Users)
        if ($fieldType === 'email') {
            // Validasi format email & pastikan ada di tabel users
            $request->merge(['email' => $input]);
            $request->validate([
                'email' => 'required|email|exists:users,email'
            ], [
                'email.exists' => 'Email ini tidak terdaftar di sistem kami.'
            ]);

            // Kirim Link (Default Laravel)
            $status = Password::sendResetLink(['email' => $input]);

            if ($status === Password::RESET_LINK_SENT) {
                return back()->with(['status' => __('Kami sudah mengirimkan tautan atur ulang kata sandi ke Email Anda!')]);
            }
            return back()->withErrors(['login_id' => __('Gagal mengirim email.')]);
        }

        // --- SKENARIO 2: JIKA USER INPUT NO HP ---
        // (Logika: Cek tabel Pegawai -> Ambil User ID -> Reset Password User tsb)
        else {
            // A. Cari Nomor HP di tabel PEGAWAI
            $pegawai = Pegawai::where('no_hp', $input)->first();

            // Jika nomor tidak ditemukan di tabel pegawai
            if (!$pegawai) {
                return back()->withErrors(['login_id' => 'Nomor WhatsApp ini tidak ditemukan di data kepegawaian.']);
            }

            // B. Cek apakah Pegawai ini punya akun Login (user_id)?
            if (!$pegawai->user_id) {
                return back()->withErrors(['login_id' => 'Data pegawai ditemukan, tapi akun Login belum diaktifkan (User ID kosong). Hubungi Admin.']);
            }

            // C. Ambil Data User berdasarkan user_id milik pegawai tadi
            $user = User::find($pegawai->user_id);

            // Jaga-jaga jika user_id ada tapi datanya sudah dihapus di tabel users
            if (!$user) {
                return back()->withErrors(['login_id' => 'Akun pengguna tidak ditemukan.']);
            }

            // D. Buat Token Reset Password Manual untuk User tersebut
            $token = Password::createToken($user);
            
            // Buat Link Reset (Kita butuh email user untuk verifikasi token nantinya)
            $link = route('password.reset', ['token' => $token, 'email' => $user->email, 'no_hp' => $pegawai->no_hp]);

            // ---------------------------------------------------------
            // SIMULASI PENGIRIMAN WA (LOG)
            // ---------------------------------------------------------
            Log::info("==========================================");
            Log::info("RESET PASSWORD VIA WHATSAPP");
            Log::info("Tujuan     : " . $pegawai->no_hp);
            Log::info("Link Reset : " . $link);
            Log::info("==========================================");

            return back()->with(['status' => 'Link reset telah dikirim ke WhatsApp Anda (Cek Log Server)!']);
        }
    }
}