<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - ERP Sekolah Juara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/pages/auth.css']) 
</head>
<body>

    <div class="login-card">
        <div class="brand-logo" style="margin-bottom: 0.5rem; font-size: 1.4rem;">
            LUPA KATA SANDI?
        </div>
        
        <p style="text-align: center; font-size: 0.9rem; color: #555; margin-bottom: 1.5rem; line-height: 1.4;">
            Masukkan email atau nomor whatsapp yang terdaftar. Kami akan mengirimkan link untuk mereset sandi Anda.
        </p>

        @if (session('status'))
            <div style="background: rgba(40, 167, 69, 0.1); color: #28a745; padding: 0.8rem; border-radius: 8px; font-size: 0.9rem; margin-bottom: 1rem; text-align: center; border: 1px solid rgba(40, 167, 69, 0.3);">
                <i class="fa-solid fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background: rgba(220, 53, 69, 0.1); color: #dc3545; padding: 0.8rem; border-radius: 8px; font-size: 0.9rem; margin-bottom: 1rem; text-align: center; border: 1px solid rgba(220, 53, 69, 0.3);">
                <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            
            <div class="form-group" style="margin-bottom: 1.2rem;">
                <label class="form-label">Email / Nomor WhatsApp</label>
                <div class="input-icon-wrapper">
                    <i class="fa-solid fa-address-book input-icon"></i>
                    
                    <input type="text" name="login_id" class="form-input with-icon" 
                           placeholder="admin@sekolah.com atau 0812xxxxxx" 
                           required autofocus value="{{ old('login_id') }}">
                </div>
            </div>

            <button type="submit" class="btn-primary" style="margin-top: 0.5rem;">
                KIRIM LINK RESET
            </button>

            <div style="text-align: center; margin-top: 1.5rem;">
                <a href="{{ route('login') }}" style="text-decoration: none; color: #666; font-size: 0.9rem; transition: 0.3s;">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </form>

        <div class="footer-text">
            &copy; 2025 Sekolah Juara Project
        </div>
    </div>

</body>
</html>