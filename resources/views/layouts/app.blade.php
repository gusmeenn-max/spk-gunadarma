<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SPK Jurusan') — Universitas Gunadarma</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --gunadarma-blue: #003d80;
            --gunadarma-navy: #001f3f;
            --gunadarma-gold: #f5a623;
            --gunadarma-light: #e8f0fe;
        }

        * {
            font-family: 'Nunito', sans-serif;
        }

        body {
            background: #f5f7fa;
        }

        /* ── Navbar ── */
        .navbar-spk {
            background: linear-gradient(135deg, var(--gunadarma-navy) 0%, var(--gunadarma-blue) 100%);
            box-shadow: 0 2px 20px rgba(0, 0, 0, .2);
            padding: 12px 0;
        }

        .navbar-brand-text {
            font-weight: 900;
            font-size: 1.15rem;
            color: #fff;
        }

        .navbar-brand-sub {
            font-size: 10px;
            color: rgba(255, 255, 255, .6);
            display: block;
        }

        /* ── Cards ── */
        .card-spk {
            border: none;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .07);
            border-radius: 14px;
            transition: transform .2s, box-shadow .2s;
        }

        .card-spk:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(0, 0, 0, .1);
        }

        /* ── Buttons ── */
        .btn-primary-spk {
            background: linear-gradient(135deg, var(--gunadarma-blue), #0066cc);
            border: none;
            color: #fff;
            font-weight: 700;
            border-radius: 50px;
            padding: 10px 28px;
            transition: all .2s;
        }

        .btn-primary-spk:hover {
            background: linear-gradient(135deg, #002d60, var(--gunadarma-blue));
            color: #fff;
            transform: translateY(-1px);
        }

        /* ── Progress bar ── */
        .progress-vi {
            background: linear-gradient(90deg, var(--gunadarma-blue), #4d94ff);
            border-radius: 50px;
        }

        /* ── Step indicator ── */
        .step-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #dee2e6;
            transition: background .3s;
        }

        .step-dot.active {
            background: var(--gunadarma-blue);
        }

        .step-dot.done {
            background: var(--gunadarma-gold);
        }

        /* ── Rank medals ── */
        .medal-1 {
            color: #f5a623;
        }

        .medal-2 {
            color: #adb5bd;
        }

        .medal-3 {
            color: #cd7f32;
        }

        /* ── Footer ── */
        .footer-spk {
            background: var(--gunadarma-navy);
            color: rgba(255, 255, 255, .6);
            padding: 20px 0;
            font-size: 13px;
        }

        @yield('extra-css')
    </style>
</head>

<body>

    {{-- ─── NAVBAR ─────────────────────────────────────────────────────── --}}
    <nav class="navbar navbar-expand-lg navbar-spk">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <i class="fas fa-graduation-cap fa-lg" style="color: var(--gunadarma-gold);"></i>
                <div>
                    <span class="navbar-brand-text">SPK Jurusan</span>
                    <span class="navbar-brand-sub">Universitas Gunadarma</span>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <i class="fas fa-bars text-white"></i>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link text-white-75 fw-semibold {{ request()->routeIs('dashboard') ? 'text-white' : '' }}">
                                <i class="fas fa-home me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.kuesioner.index') }}"
                                class="nav-link text-white-75 fw-semibold {{ request()->routeIs('user.kuesioner.*') ? 'text-white' : '' }}">
                                <i class="fas fa-clipboard-list me-1"></i>Kuesioner
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.hasil.histori') }}"
                                class="nav-link text-white-75 fw-semibold {{ request()->routeIs('user.hasil.histori') ? 'text-white' : '' }}">
                                <i class="fas fa-history me-1"></i>Riwayat
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-light dropdown-toggle fw-semibold"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->nama_lengkap }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li><span
                                            class="dropdown-item-text text-muted small">{{ Auth::user()->username }}</span>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item text-danger fw-semibold">
                                                <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light fw-semibold">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-sm fw-bold"
                                style="background:var(--gunadarma-gold); color:#fff; border:none;">Daftar Sekarang</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- ─── MAIN CONTENT ────────────────────────────────────────────────── --}}
    <main class="py-4">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-3">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-3">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show rounded-3 shadow-sm border-0 mb-3">
                    <strong><i class="fas fa-exclamation-triangle me-2"></i>Ada yang perlu diperbaiki:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- ─── FOOTER ──────────────────────────────────────────────────────── --}}
    <footer class="footer-spk mt-auto">
        <div class="container text-center">
            <p class="mb-1">
                <i class="fas fa-graduation-cap me-1" style="color:var(--gunadarma-gold);"></i>
                <strong class="text-white">SPK Pemilihan Jurusan</strong> — Universitas Gunadarma
            </p>
            <p class="mb-0">Metode TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution) &copy;
                {{ date('Y') }}</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('scripts')
</body>

</html>
