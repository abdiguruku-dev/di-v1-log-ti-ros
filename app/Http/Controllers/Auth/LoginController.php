<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pegawai;
use Laravel\Socialite\Facades\Socialite; 

class LoginController extends Controller
{
    // ... (Fungsi showLoginForm & login yang lama biarkan saja) ...
    // ... (Paste fungsi lama Anda di sini, jangan dihapus) ...

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'login_id' => ['required'], 
            'password' => ['required'],
            'login_type' => ['required'] // Pastikan ada kiriman tipe login (nip/wa)
        ]);

        $input = $request->login_id;
        $type  = $request->login_type; // Ambil nilai 'nip' atau 'wa' dari hidden input
        $targetUser = null;

        // 2. LOGIKA PENCARIAN USER (STRICT MODE)
        if ($type === 'wa') {
            // --- KASUS 1: LOGIN MODE WHATSAPP ---
            // HANYA cari di kolom no_hp. 
            // Jika user memasukkan NIP disini, query ini akan gagal (return null).
            $pegawai = Pegawai::where('no_hp', $input)->first();
            
            if ($pegawai) {
                $targetUser = $pegawai->user;
            }

        } elseif ($type === 'nip') {
            // --- KASUS 2: LOGIN MODE NIP ---
            // HANYA cari di kolom nip atau nik_ktp.
            // Jika user memasukkan No HP disini, query ini akan gagal.
            $pegawai = Pegawai::where('nip', $input)
                            ->orWhere('nik_ktp', $input)
                            ->first();
                            
            if ($pegawai) {
                $targetUser = $pegawai->user;
            }
        } 
        // Catatan: Saya hapus pengecekan Email manual di sini karena di UI Anda
        // labelnya spesifik "NIP" atau "WA". Email diarahkan lewat tombol Google.
        // Jika Anda tetap ingin support email manual, taruh di blok 'nip' atau buat blok baru.

        // 3. EKSEKUSI LOGIN
        if ($targetUser && Auth::attempt([
            'email' => $targetUser->email, // Auth Laravel butuh field 'email' untuk dicocokkan
            'password' => $request->password, 
            'is_active' => true
        ], $request->filled('remember'))) {
            
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // 4. JIKA GAGAL
        // Berikan pesan error yang spesifik agar user paham
        $errorMsg = ($type === 'wa') 
            ? 'Nomor WhatsApp tidak terdaftar atau Password salah.' 
            : 'NIP/NIK tidak ditemukan atau Password salah.';

        return back()->withErrors(['login_id' => $errorMsg])->onlyInput('login_id');
    }


    // --- FITUR BARU: GOOGLE LOGIN ---

    // 1. Arahkan User ke Halaman Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Terima Balikan dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user di database kita yang emailnya sama dengan Gmail login
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                // Jika ketemu, langsung Login
                Auth::login($existingUser);
                return redirect()->intended('dashboard');
            } else {
                // Jika email tidak ditemukan di database sekolah
                return redirect()->route('login')->withErrors([
                    'login_id' => 'Email Google ini (' . $googleUser->getEmail() . ') tidak terdaftar di sistem sekolah.',
                ]);
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['login_id' => 'Gagal login dengan Google.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}