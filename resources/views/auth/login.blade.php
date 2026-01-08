<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ERP Sekolah Juara</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/pages/_auth.css'])
</head>
<body>

    <div class="login-card">
        <div class="logo-container">
            <img src="https://cdn-icons-png.flaticon.com/512/3413/3413535.png" alt="Logo Sekolah">
        </div>

        <div class="brand-logo">
            SEKOLAH JUARA
        </div>

        @if ($errors->any())
            <div class="error-message">
                <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <input type="hidden" name="login_type" id="login_type" value="nip">
            <div class="form-group">
                <label class="form-label" id="label-login">NIP / NIY / NIK</label>
                <div class="input-icon-wrapper">
                    <i class="fa-solid fa-id-card input-icon" id="icon-login"></i>
                    <input type="text" name="login_id" id="input-login" class="form-input with-icon" 
                           placeholder="Masukkan Nomor Induk..." required autofocus value="{{ old('login_id') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Kata Sandi</label>
                <div class="input-icon-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="password" id="password" class="form-input with-icon" 
                           placeholder="••••••••" required>
                    
                    <span class="toggle-password" onclick="togglePassword()">
                        <i class="fa-solid fa-eye" id="eye-icon"></i>
                    </span>
                </div>
            </div>

            <div class="flex-between">
                <div class="checkbox-wrapper">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat Saya</label>
                </div>
                <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-primary">
                MASUK APLIKASI
            </button>

            <div class="alt-login-text">Metode Masuk Lainnya:</div>
            
            <div class="alt-login-icons">
                <div class="alt-btn active" onclick="setMode('nip')" title="Login Manual (NIP/HP)">
                    <i class="fa-solid fa-id-card"></i>
                </div>

                @if(Route::has('auth.google'))
                    <a href="{{ route('auth.google') }}" class="alt-btn" title="Login dengan Google Gmail">
                        <i class="fa-brands fa-google"></i>
                    </a>
                @else
                    <div class="alt-btn" onclick="alert('Fitur Google belum diaktifkan di routes/web.php')" title="Fitur Nonaktif">
                        <i class="fa-brands fa-google" style="opacity: 0.5"></i>
                    </div>
                @endif

                <div class="alt-btn" onclick="setMode('wa')" title="Login via No. WhatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
            </div>

        </form>

        <div class="footer-text">
            Sistem Informasi Manajemen Sekolah Terpadu <br>
            &copy; 2025 Sekolah Juara Project
        </div>
    </div>

    <script>
        // Fungsi 1: Lihat/Sembunyikan Password
        function togglePassword() {
            var x = document.getElementById("password");
            var icon = document.getElementById("eye-icon");
            if (x.type === "password") {
                x.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                x.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        // Fungsi 2: Ganti Mode Input (NIP <-> WA <-> Email)
        function setMode(mode) {
            let label = document.getElementById('label-login');
            let input = document.getElementById('input-login');
            let icon = document.getElementById('icon-login');
            let hiddenInput = document.getElementById('login_type');
            // Reset tombol aktif (hapus class active dari semua tombol div)
            document.querySelectorAll('div.alt-btn').forEach(btn => btn.classList.remove('active'));

            document.querySelectorAll('div.alt-btn').forEach(btn => btn.classList.remove('active'));

            if(mode === 'nip') {
                label.innerText = "NIP / NIY / NIK";
                input.placeholder = "Masukkan Nomor Induk...";
                icon.className = "fa-solid fa-id-card input-icon";
                
                // Set tombol aktif & ubah nilai rahasia
                document.querySelector('div[onclick="setMode(\'nip\')"]').classList.add('active');
                hiddenInput.value = 'nip'; // <--- Controller akan baca ini nanti

            } else if (mode === 'wa') {
                label.innerText = "Nomor WhatsApp";
                input.placeholder = "Contoh: 08123456789";
                icon.className = "fa-brands fa-whatsapp input-icon";
                
                // Set tombol aktif & ubah nilai rahasia
                document.querySelector('div[onclick="setMode(\'wa\')"]').classList.add('active');
                hiddenInput.value = 'wa'; // <--- Controller akan baca ini nanti
            }
            input.focus();
        }
    </script>

</body>
</html>