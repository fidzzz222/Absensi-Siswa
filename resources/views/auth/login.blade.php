<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Si Hadir SMKN 1 Kota Bekasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #93c5fd 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 440px;
            padding: 35px 30px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-school {
            height: 75px;
            object-fit: contain;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.95rem;
            border: 1px solid #d1d5db;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
        }

        .btn-login {
            background-color: #2563eb;
            color: #ffffff;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            transition: background-color 0.2s ease;
        }

        .btn-login:hover {
            background-color: #1d4ed8;
        }

        .role-chip {
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
            cursor: pointer;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #334155;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
            margin: 2px;
        }

        .role-chip:hover {
            background: #2563eb;
            color: #fff;
            border-color: #2563eb;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SMKN 1 Kota Bekasi" class="logo-school mb-2">
            <h3 class="fw-bold text-dark mb-1">Si Hadir</h3>
            <p class="text-muted small mb-0">Sistem Presensi Digital SMKN 1 Kota Bekasi</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger py-2 px-3 small rounded-3 d-flex align-items-center mb-3">
                <i class="bi bi-exclamation-circle-fill me-2 fs-6"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success py-2 px-3 small rounded-3 d-flex align-items-center mb-3">
                <i class="bi bi-check-circle-fill me-2 fs-6"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label small fw-semibold text-secondary">Email atau Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 10px 0 0 10px;">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="text" id="emailInput" name="email" class="form-control border-start-0" style="border-radius: 0 10px 10px 0;" placeholder="contoh: guru@gmail.com" required value="{{ old('email') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold text-secondary">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 10px 0 0 10px;">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" id="passwordInput" name="password" class="form-control border-start-0 border-end-0" placeholder="••••••••" required>
                    <button class="input-group-text bg-light text-muted border-start-0" type="button" onclick="togglePassword()" style="border-radius: 0 10px 10px 0;">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100 mt-2 mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Sistem
            </button>
        </form>

        <!-- Quick Login Demo Buttons -->
        <div class="border-top pt-3 mt-2 text-center">
            <div class="small text-muted fw-semibold mb-2">Akun Demo (Klik untuk auto-fill):</div>
            <div class="d-flex flex-wrap justify-content-center gap-1">
                <button type="button" class="role-chip" onclick="fillLogin('guru@gmail.com', '123456')">
                    <i class="bi bi-person-badge me-1"></i> Guru Mapel
                </button>
                <button type="button" class="role-chip" onclick="fillLogin('sekretaris@gmail.com', '123456')">
                    <i class="bi bi-journal-check me-1"></i> Sekretaris
                </button>
                <button type="button" class="role-chip" onclick="fillLogin('siswa@gmail.com', '123456')">
                    <i class="bi bi-backpack me-1"></i> Siswa
                </button>
                <button type="button" class="role-chip" onclick="fillLogin('bk@gmail.com', '123456')">
                    <i class="bi bi-heart-pulse me-1"></i> Guru BK
                </button>
                <button type="button" class="role-chip" onclick="fillLogin('piket@gmail.com', '123456')">
                    <i class="bi bi-clock me-1"></i> Guru Piket
                </button>
            </div>
        </div>
    </div>

    <script>
        function fillLogin(email, password) {
            document.getElementById('emailInput').value = email;
            document.getElementById('passwordInput').value = password;
        }

        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>

