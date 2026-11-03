@extends('layouts.app')
@section('title', 'Dashboard')

@section('extra-css')
    .welcome-banner {
    background: linear-gradient(135deg, #001f3f 0%, #003d80 60%, #0055b3 100%);
    border-radius: 18px;
    padding: 36px 40px;
    position: relative;
    overflow: hidden;
    color: #fff;
    }

    .welcome-banner::before {
    content: '';
    position: absolute;
    top: -40px;
    right: -40px;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
    }

    .welcome-banner::after {
    content: '';
    position: absolute;
    bottom: -60px;
    right: 80px;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: rgba(245, 166, 35, 0.08);
    }

    .welcome-title {
    font-size: 1.7rem;
    font-weight: 900;
    margin-bottom: 6px;
    }

    .welcome-sub {
    color: rgba(255, 255, 255, 0.75);
    font-size: 0.95rem;
    margin-bottom: 28px;
    max-width: 480px;
    line-height: 1.6;
    }

    .btn-start {
    background: #f5a623;
    color: #001f3f;
    font-weight: 800;
    border: none;
    border-radius: 50px;
    padding: 12px 32px;
    font-size: 0.95rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: .2s;
    box-shadow: 0 4px 16px rgba(245, 166, 35, 0.35);
    }

    .btn-start:hover {
    background: #e09400;
    color: #001f3f;
    transform: translateY(-2px);
    }

    .btn-histori {
    background: rgba(255, 255, 255, 0.12);
    color: #fff;
    font-weight: 700;
    border: 1.5px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    padding: 12px 28px;
    font-size: 0.95rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: .2s;
    }

    .btn-histori:hover {
    background: rgba(255, 255, 255, 0.22);
    color: #fff;
    }

    .stat-mini {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    padding: 16px 20px;
    text-align: center;
    min-width: 120px;
    }

    .stat-mini-num {
    font-size: 1.8rem;
    font-weight: 900;
    color: #f5a623;
    line-height: 1;
    }

    .stat-mini-label {
    font-size: 0.72rem;
    color: rgba(18, 1, 1, 0.65);
    margin-top: 4px;
    }

    .step-card {
    border: none;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.07);
    border-radius: 14px;
    padding: 24px;
    height: 100%;
    position: relative;
    transition: transform .2s, box-shadow .2s;
    }

    .step-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12);
    }

    .step-num {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--gunadarma-light);
    color: var(--gunadarma-blue);
    font-weight: 900;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
    flex-shrink: 0;
    }

    .step-num.active {
    background: var(--gunadarma-blue);
    color: #fff;
    }

    .step-icon {
    font-size: 1.5rem;
    margin-bottom: 12px;
    }

    .step-title {
    font-weight: 800;
    font-size: 0.95rem;
    margin-bottom: 6px;
    color: #1a2a3a;
    }

    .step-desc {
    font-size: 0.82rem;
    color: #6c757d;
    line-height: 1.5;
    }

    .connector {
    position: absolute;
    top: 32px;
    right: -18px;
    color: #dee2e6;
    font-size: 1.2rem;
    z-index: 1;
    }

    .histori-item {
    border-left: 3px solid var(--gunadarma-blue);
    padding: 12px 16px;
    background: #f8f9fa;
    border-radius: 0 10px 10px 0;
    margin-bottom: 10px;
    transition: background .15s;
    }

    .histori-item:hover {
    background: var(--gunadarma-light);
    }

    .histori-rank {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--gunadarma-blue);
    }

    .histori-date {
    font-size: 0.73rem;
    color: #adb5bd;
    }

    .kriteria-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--gunadarma-light);
    color: var(--gunadarma-blue);
    border-radius: 20px;
    padding: 5px 12px;
    font-size: 0.78rem;
    font-weight: 600;
    margin: 3px;
    }
@endsection

@section('content')

    @php $user = Auth::user(); @endphp

    {{-- ── WELCOME BANNER ─────────────────────────────────────────── --}}
    <div class="welcome-banner mb-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="welcome-title">
                    Halo, {{ $user->nama_lengkap ?? $user->username }}! 👋
                </div>
                <p class="welcome-sub">
                    Selamat datang di Sistem Pendukung Keputusan Pemilihan Jurusan Universitas Gunadarma.
                    Temukan jurusan yang paling sesuai dengan minat dan kemampuanmu melalui
                    analisis 9 kriteria menggunakan metode TOPSIS.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('user.kuesioner.index') }}" class="btn-start">
                        <i class="fas fa-rocket"></i> Mulai Kuesioner
                    </a>
                    <a href="{{ route('user.hasil.histori') }}" class="btn-histori">
                        <i class="fas fa-history"></i> Riwayat Hasil
                    </a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex gap-3 justify-content-lg-end flex-wrap">
                    <div class="stat-mini">
                        <div class="stat-mini-num">16</div>
                        <div class="stat-mini-label">Pilihan Jurusan</div>
                    </div>
                    <div class="stat-mini">
                        <div class="stat-mini-num">9</div>
                        <div class="stat-mini-label">Kriteria Analisis</div>
                    </div>
                    <div class="stat-mini">
                        <div class="stat-mini-num">{{ $totalHasil ?? 0 }}</div>
                        <div class="stat-mini-label">Kali Dihitung</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- ── CARA PENGGUNAAN ─────────────────────────────────────── --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius:14px;">
                <div class="card-header border-0 bg-white pb-0 pt-3" style="border-radius:14px 14px 0 0;">
                    <h6 class="fw-800 mb-0" style="color:#1a2a3a;">
                        <i class="fas fa-map-signs me-2" style="color:var(--gunadarma-blue);"></i>
                        Cara Menggunakan Sistem
                    </h6>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3 position-relative">

                        <div class="col-6 col-md-3 position-relative">
                            <div class="step-card">
                                <div class="step-icon">📝</div>
                                <div class="step-num active">1</div>
                                <div class="step-title">Isi Kuesioner</div>
                                <div class="step-desc">Jawab 21 pertanyaan sesuai minat dan kemampuanmu menggunakan skala
                                    1–5.</div>
                            </div>
                            <span class="connector d-none d-md-block"><i class="fas fa-chevron-right"></i></span>
                        </div>

                        <div class="col-6 col-md-3 position-relative">
                            <div class="step-card">
                                <div class="step-icon">🧮</div>
                                <div class="step-num">2</div>
                                <div class="step-title">Proses TOPSIS</div>
                                <div class="step-desc">Sistem menghitung secara otomatis menggunakan metode TOPSIS
                                    berdasarkan jawabanmu.</div>
                            </div>
                            <span class="connector d-none d-md-block"><i class="fas fa-chevron-right"></i></span>
                        </div>

                        <div class="col-6 col-md-3 position-relative">
                            <div class="step-card">
                                <div class="step-icon">🏆</div>
                                <div class="step-num">3</div>
                                <div class="step-title">Lihat Ranking</div>
                                <div class="step-desc">Dapatkan ranking 16 jurusan lengkap dengan persentase kecocokan
                                    masing-masing.</div>
                            </div>
                            <span class="connector d-none d-md-block"><i class="fas fa-chevron-right"></i></span>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="step-card">
                                <div class="step-icon">📄</div>
                                <div class="step-num">4</div>
                                <div class="step-title">Simpan & Cetak</div>
                                <div class="step-desc">Hasil tersimpan otomatis di riwayat dan bisa dicetak sebagai PDF
                                    kapan saja.</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- ── RIWAYAT TERAKHIR ────────────────────────────────────── --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                <div class="card-header border-0 bg-white d-flex justify-content-between align-items-center pt-3 pb-0">
                    <h6 class="fw-800 mb-0" style="color:#1a2a3a;">
                        <i class="fas fa-history me-2" style="color:var(--gunadarma-blue);"></i>
                        Riwayat Perhitungan Terakhir
                    </h6>
                    <a href="{{ route('user.hasil.histori') }}" class="btn btn-sm btn-outline-primary"
                        style="border-radius:20px;font-size:0.78rem;">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body">
                    @forelse($riwayatTerakhir ?? [] as $h)
                        @php
                            $detail = is_string($h->detail_hasil)
                                ? json_decode($h->detail_hasil, true)
                                : $h->detail_hasil;
                            $top = collect($detail)->first();
                        @endphp
                        <div class="histori-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="histori-rank">
                                        🥇 {{ $top['nama_jurusan'] ?? '—' }}
                                        <span class="ms-1 text-muted fw-normal">({{ $top['vi_persen'] ?? 0 }}%)</span>
                                    </div>
                                    @if (isset($detail[1]))
                                        <div class="histori-date mt-1">
                                            🥈 {{ $detail[1]['nama_jurusan'] ?? '—' }} &nbsp;·&nbsp;
                                            🥉 {{ $detail[2]['nama_jurusan'] ?? '—' }}
                                        </div>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <div class="histori-date">
                                        {{ \Carbon\Carbon::parse($h->tanggal_hitung)->format('d M Y') }}
                                    </div>
                                    <a href="{{ route('user.hasil.show', $h->id_hasil) }}" class="btn btn-xs mt-1"
                                        style="font-size:11px;padding:3px 10px;border-radius:20px;background:var(--gunadarma-light);color:var(--gunadarma-blue);font-weight:700;text-decoration:none;">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-2x mb-3 d-block" style="color:#dee2e6;"></i>
                            <div class="fw-600">Belum ada riwayat perhitungan</div>
                            <small>Mulai kuesioner untuk mendapatkan rekomendasi jurusanmu.</small>
                            <div class="mt-3">
                                <a href="{{ route('user.kuesioner.index') }}" class="btn btn-primary-spk btn-sm">
                                    <i class="fas fa-rocket me-1"></i>Mulai Sekarang
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ── INFO KRITERIA ───────────────────────────────────────── --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                <div class="card-header border-0 bg-white pt-3 pb-0">
                    <h6 class="fw-800 mb-0" style="color:#1a2a3a;">
                        <i class="fas fa-sliders-h me-2" style="color:var(--gunadarma-gold);"></i>
                        9 Kriteria yang Dianalisis
                    </h6>
                    <small class="text-muted">Penilaian berdasarkan profil minat & kemampuanmu</small>
                </div>
                <div class="card-body">
                    @php
                        $kriteriaList = [
                            ['icon' => '📐', 'label' => 'Minat Matematika & Logika'],
                            ['icon' => '💻', 'label' => 'Minat Pemrograman & Teknologi'],
                            ['icon' => '📊', 'label' => 'Minat Bisnis & Ekonomi'],
                            ['icon' => '🎨', 'label' => 'Minat Desain & Kreativitas'],
                            ['icon' => '🗣️', 'label' => 'Minat Komunikasi & Sosial'],
                            ['icon' => '⚗️', 'label' => 'Minat Sains & Rekayasa'],
                            ['icon' => '🧠', 'label' => 'Minat Psikologi & Perilaku'],
                            ['icon' => '🌐', 'label' => 'Kemampuan Bahasa Inggris'],
                            ['icon' => '🏥', 'label' => 'Minat Kesehatan & Medis'],
                        ];
                    @endphp
                    <div class="d-flex flex-wrap mt-1">
                        @foreach ($kriteriaList as $k)
                            <span class="kriteria-badge">
                                {{ $k['icon'] }} {{ $k['label'] }}
                            </span>
                        @endforeach
                    </div>

                    <div class="mt-4 p-3 rounded-3"
                        style="background:#f0f4ff;border-left:3px solid var(--gunadarma-blue);">
                        <div class="fw-700 small mb-1" style="color:var(--gunadarma-blue);">
                            <i class="fas fa-info-circle me-1"></i>Cara Penilaian
                        </div>
                        <div class="small text-muted" style="line-height:1.6;">
                            Setiap kriteria dinilai melalui beberapa pertanyaan kuesioner dengan skala
                            <strong>1 (Sangat Tidak Setuju)</strong> hingga <strong>5 (Sangat Setuju)</strong>.
                            Jawaban yang jujur akan menghasilkan rekomendasi yang lebih akurat.
                        </div>
                    </div>

                    <div class="mt-3 text-center">
                        <a href="{{ route('user.kuesioner.index') }}" class="btn btn-primary-spk w-100">
                            <i class="fas fa-clipboard-list me-2"></i>Mulai Kuesioner Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
