<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Sandi - ERP Sekolah Juara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/pages/auth.css']) 
</head>
<body>
    <div class="login-card">
        <div class="logo-container">
            <img src="https://cdn-icons-png.flaticon.com/512/3413/3413535.png" alt="Logo Sekolah">
        </div>

        <div class="brand-logo" style="margin-bottom: 0.5rem; font-size: 1.4rem;">
            UBAH KATA SANDI
        </div>
        
        @if ($errors->any())
            <div class="error-message">
                <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            @if(!empty($no_hp))
                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp</label>
                    <div class="input-icon-wrapper">
                        <i class="fa-solid fa-phone input-icon"></i>
                        <input type="text" class="form-input with-icon" 
                               value="{{ $no_hp }}" readonly 
                               style="background: #f0f0f0; color: #666; cursor: not-allowed;">
                        
                        <input type="hidden" name="email" value="{{ $email }}">
                    </div>
                </div>
            @else
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-icon-wrapper">
                        <i class="fa-solid fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-input with-icon" 
                               value="{{ $email ?? old('email') }}" required readonly 
                               style="background: #f0f0f0; color: #666; cursor: not-allowed;">
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label class="form-label">Sandi Baru</label>
                <div class="input-icon-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="password" id="password" class="form-input with-icon" 
                           placeholder="Minimal 8 karakter" required autofocus>
                    
                    <span class="toggle-password" onclick="togglePassword('password', 'eye-1')">
                        <i class="fa-solid fa-eye" id="eye-1"></i>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ulangi Sandi Baru</label>
                <div class="input-icon-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="password_confirmation" id="password-confirm" class="form-input with-icon" 
                           placeholder="Ketik ulang sandi" required>
                    
                    <span class="toggle-password" onclick="togglePassword('password-confirm', 'eye-2')">
                        <i class="fa-solid fa-eye" id="eye-2"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="margin-top: 0.5rem;">
                SIMPAN SANDI BARU
            </button>
        </form>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            var input = document.getElementById(inputId);
            var icon = document.getElementById(iconId);
            
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>