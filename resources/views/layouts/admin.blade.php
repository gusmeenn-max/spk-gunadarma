<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | SPK Gunadarma</title>

    {{-- AdminLTE CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --gunadarma-blue : #003d80;
            --gunadarma-gold : #f5a623;
            --sidebar-bg     : #001f3f;
        }
        body { font-family: 'Nunito', sans-serif; }

        /* Sidebar */
        .main-sidebar { background: var(--sidebar-bg) !important; }
        .brand-link   { background: var(--gunadarma-blue) !important; border-bottom: 1px solid rgba(255,255,255,.1); }
        .brand-text   { font-weight: 800; letter-spacing: .5px; color: #fff !important; }
        .sidebar .nav-link { color: rgba(255,255,255,.75) !important; font-weight: 600; border-radius: 6px; margin: 2px 8px; }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active { background: var(--gunadarma-blue) !important; color: #fff !important; }
        .nav-header  { color: rgba(255,255,255,.4) !important; font-size: 11px; letter-spacing: 1px; padding: 12px 16px 4px; }

        /* Top Navbar */
        .main-header.navbar { background: var(--gunadarma-blue) !important; border-bottom: none; }
        .main-header .nav-link { color: rgba(255,255,255,.8) !important; }

        /* Content Header */
        .content-header h1 { font-weight: 800; color: var(--gunadarma-blue); font-size: 1.4rem; }

        /* Cards */
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,.06); border-radius: 10px; }
        .card-header { background: #fff; border-bottom: 2px solid #f0f0f0; font-weight: 700; border-radius: 10px 10px 0 0 !important; }

        /* Info boxes */
        .info-box { border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.06); }

        /* Buttons */
        .btn { border-radius: 6px; font-weight: 600; }
        .btn-primary { background: var(--gunadarma-blue); border-color: var(--gunadarma-blue); }
        .btn-primary:hover { background: #002d60; border-color: #002d60; }

        /* Tables */
        .table th { font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; }
        .table td  { vertical-align: middle; }

        /* Badges */
        .badge-benefit { background: #d4edda; color: #155724; }
        .badge-cost    { background: #f8d7da; color: #721c24; }

        @yield('extra-css')
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- ─── NAVBAR ──────────────────────────────────────────────── --}}
    <nav class="main-header navbar navbar-expand navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link fw-semibold">
                    <i class="fas fa-home me-1"></i> Dashboard
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link text-white-50 small">
                    <i class="fas fa-user-shield me-1"></i>{{ Auth::user()->nama_lengkap }}
                </span>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link" style="color:rgba(255,255,255,.8)">
                        <i class="fas fa-sign-out-alt me-1"></i> Keluar
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    {{-- ─── SIDEBAR ─────────────────────────────────────────────── --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('admin.dashboard') }}" class="brand-link px-3">
            <i class="fas fa-graduation-cap me-2" style="color: var(--gunadarma-gold); font-size:1.4rem;"></i>
            <span class="brand-text">SPK Gunadarma</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center" style="border-bottom:1px solid rgba(255,255,255,.1)">
                <div class="image">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:35px;height:35px;background:var(--gunadarma-gold);">
                        <i class="fas fa-user-tie text-white" style="font-size:16px;"></i>
                    </div>
                </div>
                <div class="info ms-2">
                    <span class="d-block text-white fw-bold" style="font-size:13px;">{{ Auth::user()->nama_lengkap }}</span>
                    <small class="text-white-50">Administrator</small>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                    <li class="nav-header">UTAMA</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">DATA MASTER</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.jurusan.index') }}" class="nav-link {{ request()->routeIs('admin.jurusan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-university"></i>
                            <p>Manajemen Jurusan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.kriteria.index') }}" class="nav-link {{ request()->routeIs('admin.kriteria.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-sliders-h"></i>
                            <p>Kriteria & Bobot</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.penilaian.index') }}" class="nav-link {{ request()->routeIs('admin.penilaian.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-table"></i>
                            <p>Matriks Penilaian</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.kuesioner.index') }}" class="nav-link {{ request()->routeIs('admin.kuesioner.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Kelola Kuesioner</p>
                        </a>
                    </li>

                    <li class="nav-header">MONITORING</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.hasil.index') }}" class="nav-link {{ request()->routeIs('admin.hasil.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Monitor Hasil SPK</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Manajemen User</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    {{-- ─── CONTENT ─────────────────────────────────────────────── --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                        <strong><i class="fas fa-times-circle me-2"></i>Terdapat kesalahan:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    {{-- ─── FOOTER ──────────────────────────────────────────────── --}}
    <footer class="main-footer">
        <strong>SPK Pemilihan Jurusan — Universitas Gunadarma</strong>
        <span class="float-right">Metode TOPSIS &copy; {{ date('Y') }}</span>
    </footer>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@yield('scripts')
</body>
</html>
