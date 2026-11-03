<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SPK Jurusan Gunadarma</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Nunito', sans-serif; }
        body {
            background: linear-gradient(135deg, #001f3f 0%, #003d80 60%, #0055aa 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
        }
        .auth-header {
            background: linear-gradient(135deg, #001f3f, #003d80);
            padding: 36px 40px 28px;
            text-align: center;
        }
        .auth-body { padding: 36px 40px; }
        .form-floating label { color: #6c757d; }
        .form-floating .form-control:focus { border-color: #003d80; box-shadow: 0 0 0 3px rgba(0,61,128,.15); }
        .btn-login {
            background: linear-gradient(135deg, #003d80, #0066cc);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-weight: 800;
            font-size: 1rem;
            width: 100%;
            transition: all .2s;
        }
        .btn-login:hover { background: linear-gradient(135deg, #002d60, #003d80); transform: translateY(-1px); color: #fff; }
        .divider { text-align:center; position:relative; margin: 20px 0; }
        .divider::before { content:''; position:absolute; top:50%; left:0; right:0; height:1px; background:#dee2e6; }
        .divider span { background:#fff; padding: 0 12px; color:#6c757d; font-size:13px; position:relative; }
    </style>
</head>
<body>
<div class="container px-3">
    <div class="auth-card mx-auto">
        <div class="auth-header">
            <i class="fas fa-graduation-cap mb-3" style="font-size:2.5rem; color:#f5a623;"></i>
            <h4 class="fw-bold text-white mb-1">SPK Pemilihan Jurusan</h4>
            <p class="text-white-50 small mb-0">Universitas Gunadarma — Metode TOPSIS</p>
        </div>
        <div class="auth-body">
            <h5 class="fw-bold mb-1" style="color:#001f3f;">Selamat Datang Kembali</h5>
            <p class="text-muted small mb-4">Masuk ke akun Anda untuk melanjutkan</p>

            @if(session('success'))
                <div class="alert alert-success py-2 small"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3 @error('username') is-invalid @enderror"
                           id="username" name="username" placeholder="Username"
                           value="{{ old('username') }}" autofocus>
                    <label for="username"><i class="fas fa-user me-1"></i> Username</label>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror"
                           id="password" name="password" placeholder="Password">
                    <label for="password"><i class="fas fa-lock me-1"></i> Password</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label small text-muted" for="remember">Ingat saya</label>
                    </div>
                </div>
                <button type="submit" class="btn-login mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </button>
            </form>

            <div class="divider"><span>atau</span></div>

            <div class="text-center mt-3">
                <p class="text-muted small mb-0">Belum punya akun?
                    <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color:#003d80;">Daftar Sekarang</a>
                </p>
            </div>

        </div>
    </div>
    <p class="text-center text-white-50 small mt-3">
        <a href="{{ route('home') }}" class="text-white-50 text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Beranda
        </a>
    </p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
