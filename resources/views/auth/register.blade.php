<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — SPK Jurusan Gunadarma</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Nunito', sans-serif; }
        body {
            background: linear-gradient(135deg, #001f3f 0%, #003d80 60%, #0055aa 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 20px 0;
        }
        .auth-card { background:#fff; border-radius:20px; box-shadow:0 20px 60px rgba(0,0,0,.3); width:100%; max-width:480px; overflow:hidden; }
        .auth-header { background:linear-gradient(135deg,#001f3f,#003d80); padding:28px 40px 22px; text-align:center; }
        .auth-body { padding:32px 40px; }
        .form-control:focus { border-color:#003d80; box-shadow:0 0 0 3px rgba(0,61,128,.12); }
        .btn-register { background:linear-gradient(135deg,#003d80,#0066cc); color:#fff; border:none; border-radius:10px; padding:13px; font-weight:800; width:100%; transition:all .2s; }
        .btn-register:hover { background:linear-gradient(135deg,#002d60,#003d80); color:#fff; transform:translateY(-1px); }
        .form-label { font-weight:700; font-size:13px; color:#495057; }
        .section-title { font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#6c757d; font-weight:700; margin-bottom:12px; }
    </style>
</head>
<body>
<div class="container px-3">
    <div class="auth-card mx-auto">
        <div class="auth-header">
            <i class="fas fa-user-plus mb-2" style="font-size:2rem; color:#f5a623;"></i>
            <h5 class="fw-bold text-white mb-1">Daftar Akun Baru</h5>
            <p class="text-white-50 small mb-0">SPK Pemilihan Jurusan — Universitas Gunadarma</p>
        </div>
        <div class="auth-body">
            <form action="{{ route('register') }}" method="POST">
                @csrf

                {{-- Informasi Pribadi --}}
                <div class="section-title"><i class="fas fa-user me-1"></i>Informasi Pribadi</div>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control rounded-3 @error('nama_lengkap') is-invalid @enderror"
                           value="{{ old('nama_lengkap') }}" placeholder="Contoh: Budi Santoso">
                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label">NIM <small class="text-muted">(opsional)</small></label>
                        <input type="text" name="nim" class="form-control rounded-3 @error('nim') is-invalid @enderror"
                               value="{{ old('nim') }}" placeholder="10001001">
                        @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Asal Sekolah <small class="text-muted">(opsional)</small></label>
                        <input type="text" name="asal_sekolah" class="form-control rounded-3 @error('asal_sekolah') is-invalid @enderror"
                               value="{{ old('asal_sekolah') }}" placeholder="SMA Negeri 1">
                        @error('asal_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <hr class="my-3">

                {{-- Akun --}}
                <div class="section-title"><i class="fas fa-key me-1"></i>Data Akun</div>
                <div class="mb-3">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control rounded-3 @error('username') is-invalid @enderror"
                           value="{{ old('username') }}" placeholder="budi_santoso">
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email <small class="text-muted">(opsional)</small></label>
                    <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="budi@email.com">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control rounded-3 @error('password') is-invalid @enderror"
                               placeholder="Min. 6 karakter">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control rounded-3" placeholder="Ulangi password">
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus me-2"></i>Buat Akun Sekarang
                </button>
            </form>

            <div class="text-center mt-3">
                <p class="text-muted small mb-0">Sudah punya akun?
                    <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color:#003d80;">Masuk di sini</a>
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
