<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SPK Gunadarma – Temukan Jurusan Terbaikmu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #0a1628;
            color: #fff;
            min-height: 100vh;
        }

        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 60px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(10, 22, 40, 0.92);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.15rem;
            text-decoration: none;
            color: #fff;
        }

        .logo-icon {
            font-size: 1.5rem;
        }

        .nav-btns {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-outline {
            padding: 9px 22px;
            border: 2px solid #fff;
            background: transparent;
            color: #fff;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline:hover {
            background: #fff;
            color: #0a1628;
        }

        .btn-gold {
            padding: 9px 22px;
            background: #f5a623;
            color: #0a1628;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-gold:hover {
            background: #e09400;
        }

        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a1628 0%, #0d2044 50%, #0a1628 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 60px 60px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 60% 50%, rgba(30, 80, 200, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.06) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .hero-inner {
            max-width: 1200px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
            position: relative;
            z-index: 1;
        }

        .hero-left {
            flex: 1;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(245, 166, 35, 0.15);
            border: 1px solid rgba(245, 166, 35, 0.4);
            color: #f5a623;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 24px;
        }

        h1 {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 20px;
        }

        h1 span {
            color: #f5a623;
        }

        .hero-desc {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.05rem;
            line-height: 1.7;
            max-width: 520px;
            margin-bottom: 36px;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 48px;
        }

        .btn-primary {
            padding: 14px 30px;
            background: #f5a623;
            color: #0a1628;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: .2s;
            box-shadow: 0 4px 20px rgba(245, 166, 35, 0.35);
            text-decoration: none;
        }

        .btn-primary:hover {
            background: #e09400;
            transform: translateY(-1px);
        }

        .btn-secondary {
            padding: 14px 30px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: .2s;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .stats {
            display: flex;
            gap: 40px;
        }

        .stat {
            display: flex;
            flex-direction: column;
        }

        .stat-num {
            font-size: 1.8rem;
            font-weight: 800;
            color: #f5a623;
        }

        .stat-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.55);
            margin-top: 2px;
        }

        .hero-right {
            flex-shrink: 0;
        }

        .result-card {
            background: #fff;
            color: #0a1628;
            border-radius: 20px;
            padding: 24px;
            width: 340px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-dots {
            display: flex;
            gap: 6px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .dot-r {
            background: #ff5f57;
        }

        .dot-y {
            background: #febc2e;
        }

        .dot-g {
            background: #28c840;
        }

        .card-title {
            font-size: 0.82rem;
            font-weight: 600;
            color: #555;
        }

        .rank-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .rank-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .rank-1 {
            background: #f5a623;
            color: #fff;
        }

        .rank-2 {
            background: #aaa;
            color: #fff;
        }

        .rank-3 {
            background: #cd7f32;
            color: #fff;
        }

        .rank-info {
            flex: 1;
        }

        .rank-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: #0a1628;
        }

        .rank-fak {
            font-size: 0.73rem;
            color: #666;
            margin-top: 1px;
        }

        .rank-bar-wrap {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 3px;
        }

        .rank-pct {
            font-size: 0.82rem;
            font-weight: 700;
            color: #0a1628;
        }

        .bar-bg {
            width: 80px;
            height: 6px;
            background: #e5e5e5;
            border-radius: 3px;
        }

        .bar-fill {
            height: 6px;
            border-radius: 3px;
        }

        .bar-gold {
            background: #f5a623;
        }

        .bar-silver {
            background: #aaa;
        }

        .bar-bronze {
            background: #cd7f32;
        }

        .card-footer {
            margin-top: 16px;
            background: #f0f4ff;
            border-radius: 10px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-footer-icon {
            font-size: 1.1rem;
        }

        .card-footer-text {
            font-size: 0.78rem;
            color: #334;
            font-weight: 600;
        }

        .info-section {
            background: #0d1f3c;
            padding: 80px 60px;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .section-sub {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 1rem;
            margin-bottom: 52px;
        }

        .features {
            display: flex;
            gap: 24px;
            justify-content: center;
            flex-wrap: wrap;
            max-width: 900px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 28px 24px;
            flex: 1;
            min-width: 200px;
            max-width: 240px;
            text-align: center;
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 14px;
        }

        .feature-title {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .feature-desc {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.5;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav>
        <a href="{{ route('home') }}" class="logo">
            <span class="logo-icon">🎓</span>
            SPK Gunadarma
        </a>
        <div class="nav-btns">
            <a href="{{ route('login') }}" class="btn-outline">Masuk</a>
            <a href="{{ route('register') }}" class="btn-gold">Daftar Gratis</a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-inner">
            <!-- LEFT -->
            <div class="hero-left">
                <div class="badge">
                    ⭐ Metode TOPSIS — Sistem Pendukung Keputusan
                </div>
                <h1>Temukan <span>Jurusan Terbaik</span> untuk Masa Depanmu</h1>
                <p class="hero-desc">
                    Bingung memilih jurusan di Universitas Gunadarma? Sistem kami menganalisis
                    minat dan kemampuanmu melalui <strong>21 pertanyaan kuesioner</strong> menggunakan
                    metode TOPSIS untuk memberikan rekomendasi jurusan yang paling tepat.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn-primary">🚀 Mulai Sekarang — Gratis!</a>
                    <a href="{{ route('login') }}" class="btn-secondary">→ Sudah Punya Akun</a>
                </div>
                <div class="stats">
                    <div class="stat">
                        <span class="stat-num">16</span>
                        <span class="stat-label">Pilihan Jurusan</span>
                    </div>
                    <div class="stat">
                        <span class="stat-num">9</span>
                        <span class="stat-label">Kriteria Analisis</span>
                    </div>
                    <div class="stat">
                        <span class="stat-num">100%</span>
                        <span class="stat-label">Berbasis Data</span>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Result Card -->
            <div class="hero-right">
                <div class="result-card">
                    <div class="card-header">
                        <div class="card-dots">
                            <div class="dot dot-r"></div>
                            <div class="dot dot-y"></div>
                            <div class="dot dot-g"></div>
                        </div>
                        <span class="card-title">Hasil Rekomendasi TOPSIS</span>
                    </div>

                    <div class="rank-item">
                        <div class="rank-badge rank-1">🥇</div>
                        <div class="rank-info">
                            <div class="rank-name">Sistem Informasi</div>
                            <div class="rank-fak">Fak. Ilmu Komputer & TI</div>
                        </div>
                        <div class="rank-bar-wrap">
                            <span class="rank-pct">63%</span>
                            <div class="bar-bg">
                                <div class="bar-fill bar-gold" style="width:63%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="rank-item">
                        <div class="rank-badge rank-2">🥈</div>
                        <div class="rank-info">
                            <div class="rank-name">Teknik Informatika</div>
                            <div class="rank-fak">Fak. Teknologi Industri</div>
                        </div>
                        <div class="rank-bar-wrap">
                            <span class="rank-pct">60%</span>
                            <div class="bar-bg">
                                <div class="bar-fill bar-silver" style="width:60%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="rank-item">
                        <div class="rank-badge rank-3">🥉</div>
                        <div class="rank-info">
                            <div class="rank-name">Sistem Komputer</div>
                            <div class="rank-fak">Fak. Ilmu Komputer & TI</div>
                        </div>
                        <div class="rank-bar-wrap">
                            <span class="rank-pct">59%</span>
                            <div class="bar-bg">
                                <div class="bar-fill bar-bronze" style="width:59%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <span class="card-footer-icon">✅</span>
                        <span class="card-footer-text">Berdasarkan 21 pertanyaan kuesioner &amp; 9 kriteria
                            TOPSIS</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- INFO SECTION -->
    <section class="info-section">
        <h2 class="section-title">Kenapa Gunakan SPK Gunadarma?</h2>
        <p class="section-sub">Sistem rekomendasi berbasis metode ilmiah, bukan hanya tebakan</p>
        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">🧮</div>
                <div class="feature-title">Metode TOPSIS</div>
                <div class="feature-desc">Algoritma multikriteria yang terbukti akurat untuk pengambilan keputusan</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📋</div>
                <div class="feature-title">21 Pertanyaan</div>
                <div class="feature-desc">Kuesioner terstruktur yang mencakup 9 dimensi minat dan kemampuanmu</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎓</div>
                <div class="feature-title">16 Jurusan S1</div>
                <div class="feature-desc">Seluruh pilihan program studi aktif di Universitas Gunadarma</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <div class="feature-title">Hasil Instan</div>
                <div class="feature-desc">Ranking lengkap dengan persentase kecocokan tampil dalam hitungan detik</div>
            </div>
        </div>
    </section>

</body>

</html>
