@extends('layouts.app')
@section('title', 'Hasil Rekomendasi Jurusan')

@section('extra-css')
<style>
    .hero-result {
        background: linear-gradient(135deg, #001f3f 0%, #003d80 60%, #0055aa 100%);
        border-radius: 20px;
        padding: 40px;
        color: #fff;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    .hero-result::before {
        content: '';
        position: absolute; top: -50%; right: -10%;
        width: 400px; height: 400px;
        background: rgba(255,255,255,.03);
        border-radius: 50%;
    }
    .rank-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,.08);
        transition: transform .2s, box-shadow .2s;
        height: 100%;
        overflow: hidden;
    }
    .rank-card:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(0,0,0,.12); }
    .rank-card.rank-1 { border-top: 4px solid #f5a623; }
    .rank-card.rank-2 { border-top: 4px solid #adb5bd; }
    .rank-card.rank-3 { border-top: 4px solid #cd7f32; }
    .vi-bar { height: 10px; border-radius: 50px; background: linear-gradient(90deg, #003d80, #4d94ff); }
    .step-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 16px;
        border-left: 4px solid #003d80;
        margin-bottom: 12px;
    }
    .step-box code { background: #e8f0fe; color: #003d80; padding: 2px 6px; border-radius: 4px; font-size: 12px; }
    .tbl-matrix th, .tbl-matrix td { font-size: 12px; padding: 6px 10px; }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
<div class="col-lg-11">

    {{-- ── Hero Rekomendasi Utama ────────────────────────────────── --}}
    <div class="hero-result text-center">
        <div class="mb-2">
            <span style="font-size: 2.5rem;">🎓</span>
        </div>
        <p class="mb-1 text-white-50" style="font-size:13px; letter-spacing:1px; text-transform:uppercase; font-weight:700;">
            Berdasarkan Profil Anda
        </p>
        <h2 class="fw-bold mb-1" style="font-size:1.3rem;">Rekomendasi Jurusan Terbaik Anda:</h2>
        @if(!empty($hasil->detail_hasil[0]))
        @php $top = $hasil->detail_hasil[0]; @endphp
        <h1 class="fw-bold mb-2" style="font-size:2.2rem; color:#f5a623;">
            {{ $top['nama_jurusan'] }}
        </h1>
        <div class="d-flex justify-content-center gap-3 flex-wrap mb-3">
            <span class="badge px-3 py-2" style="background:rgba(255,255,255,.15); font-size:13px;">
                <i class="fas fa-graduation-cap me-1"></i>{{ $top['jenjang'] }}
            </span>
            <span class="badge px-3 py-2" style="background:rgba(255,255,255,.15); font-size:13px;">
                <i class="fas fa-university me-1"></i>{{ $top['fakultas'] }}
            </span>
        </div>
        <div class="d-inline-flex align-items-center gap-3 px-5 py-3 rounded-pill"
             style="background:rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2);">
            <div>
                <div style="font-size:13px; color:rgba(255,255,255,.7);">Tingkat Kecocokan</div>
                <div style="font-size:2.4rem; font-weight:900; color:#f5a623; line-height:1;">
                    {{ $top['vi_persen'] }}%
                </div>
            </div>
            <div style="width:1px; height:50px; background:rgba(255,255,255,.2);"></div>
            <div>
                <div style="font-size:13px; color:rgba(255,255,255,.7);">Nilai V<sub>i</sub></div>
                <div style="font-size:1.6rem; font-weight:800; color:#fff;">
                    {{ number_format($top['vi'], 4) }}
                </div>
            </div>
        </div>
        @endif
        <div class="mt-3">
            <small class="text-white-50">
                <i class="fas fa-calendar me-1"></i>Dihitung pada {{ $hasil->tanggal_hitung->format('d F Y, H:i') }} WIB
            </small>
        </div>
    </div>

    {{-- ── Top 3 Rekomendasi ─────────────────────────────────────── --}}
    <h5 class="fw-bold mb-3">
        <i class="fas fa-trophy me-2" style="color:#f5a623;"></i>Top 3 Rekomendasi Jurusan
    </h5>
    <div class="row g-3 mb-5">
        @foreach(array_slice($hasil->detail_hasil, 0, 3) as $i => $r)
        <div class="col-md-4">
            <div class="rank-card card rank-{{ $i+1 }}">
                <div class="card-body p-4 text-center">
                    <div style="font-size:2rem; margin-bottom:8px;">
                        {{ $i==0?'🥇':($i==1?'🥈':'🥉') }}
                    </div>
                    <div class="fw-bold" style="font-size:11px; color:#6c757d; letter-spacing:.5px; text-transform:uppercase;">Peringkat #{{ $i+1 }}</div>
                    <h5 class="fw-bold mt-1 mb-1" style="color:#003d80;">{{ $r['nama_jurusan'] }}</h5>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge {{ $r['jenjang']=='S1'?'bg-primary':'bg-info' }}">{{ $r['jenjang'] }}</span>
                        <span class="badge bg-light text-dark" style="font-size:10px;">{{ $r['fakultas'] }}</span>
                    </div>
                    <div class="progress mb-2" style="height:10px; border-radius:50px;">
                        <div class="vi-bar" style="width:{{ $r['vi_persen'] }}%;"></div>
                    </div>
                    <div class="fw-bold" style="font-size:1.4rem; color:{{ $i==0?'#f5a623':($i==1?'#adb5bd':'#cd7f32') }};">
                        {{ $r['vi_persen'] }}%
                    </div>
                    <small class="text-muted">V<sub>i</sub> = {{ number_format($r['vi'], 4) }}</small>
                    <div class="mt-2 pt-2 border-top d-flex justify-content-center gap-3">
                        <div class="text-center">
                            <div class="fw-bold small text-danger">{{ number_format($r['d_plus'], 4) }}</div>
                            <div style="font-size:10px; color:#6c757d;">D⁺</div>
                        </div>
                        <div class="text-center">
                            <div class="fw-bold small text-success">{{ number_format($r['d_minus'], 4) }}</div>
                            <div style="font-size:10px; color:#6c757d;">D⁻</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Grafik Chart.js ───────────────────────────────────────── --}}
    <div class="card-spk card mb-5">
        <div class="card-body">
            <h6 class="fw-bold mb-3" style="color:#003d80;">
                <i class="fas fa-chart-bar me-2" style="color:#f5a623;"></i>
                Grafik Perbandingan Nilai Preferensi V<sub>i</sub> (Top 10)
            </h6>
            <canvas id="chartVi" height="80"></canvas>
        </div>
    </div>

    {{-- ── Tabel Ranking Lengkap ─────────────────────────────────── --}}
    <div class="card-spk card mb-5">
        <div class="card-body p-0">
            <div class="px-4 pt-4 pb-2">
                <h6 class="fw-bold" style="color:#003d80;">
                    <i class="fas fa-table me-2" style="color:#f5a623;"></i>
                    Tabel Ranking Lengkap — Semua Jurusan
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 tbl-matrix">
                    <thead class="table-light">
                        <tr>
                            <th>Rank</th>
                            <th>Jurusan</th>
                            <th>Jenjang</th>
                            <th>D⁺</th>
                            <th>D⁻</th>
                            <th>V<sub>i</sub></th>
                            <th style="min-width:150px;">Kecocokan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hasil->detail_hasil as $r)
                        <tr class="{{ $r['peringkat'] == 1 ? 'table-warning' : ($r['peringkat'] <= 3 ? 'table-light' : '') }}">
                            <td>
                                <span class="fw-bold {{ $r['peringkat']==1?'text-warning':($r['peringkat']<=3?'text-secondary':'text-muted') }}">
                                    {{ $r['peringkat']==1?'🥇':($r['peringkat']==2?'🥈':($r['peringkat']==3?'🥉':'#'.$r['peringkat'])) }}
                                </span>
                            </td>
                            <td class="fw-semibold">{{ $r['nama_jurusan'] }}</td>
                            <td><span class="badge {{ $r['jenjang']=='S1'?'bg-primary':'bg-info' }}">{{ $r['jenjang'] }}</span></td>
                            <td><code style="font-size:11px;">{{ number_format($r['d_plus'],4) }}</code></td>
                            <td><code style="font-size:11px;">{{ number_format($r['d_minus'],4) }}</code></td>
                            <td><strong>{{ number_format($r['vi'],4) }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height:8px; border-radius:50px;">
                                        <div class="vi-bar" style="width:{{ $r['vi_persen'] }}%;"></div>
                                    </div>
                                    <small class="fw-bold" style="min-width:38px; color:#003d80;">{{ $r['vi_persen'] }}%</small>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ── Detail Matriks TOPSIS ─────────────────────────────────── --}}
    <div class="accordion mb-5" id="accordionTopsis">

        {{-- Matriks Keputusan --}}
        <div class="accordion-item border-0 mb-2 rounded-3 overflow-hidden shadow-sm">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseX">
                    <i class="fas fa-table me-2" style="color:#003d80;"></i>
                    Langkah 1 — Matriks Keputusan (X)
                </button>
            </h2>
            <div id="collapseX" class="accordion-collapse collapse" data-bs-parent="#accordionTopsis">
                <div class="accordion-body p-0">
                    <div class="step-box mx-3 mt-3">
                        <code>X[i][j] = nilai_standar_jurusan × (input_user / 5)</code>
                        <span class="ms-2 text-muted small">Menggabungkan profil jurusan dengan preferensi user</span>
                    </div>
                    <div class="table-responsive px-3 pb-3">
                        <table class="table table-bordered table-sm tbl-matrix mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Jurusan</th>
                                    @foreach($kriteria as $k)
                                        <th>{{ $k->kode_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hasil->matriks_keputusan as $idJ => $baris)
                                <tr>
                                    <td class="fw-semibold" style="white-space:nowrap;">
                                        {{ $hasil->detail_hasil[array_search($idJ, array_column($hasil->detail_hasil, 'id_jurusan'))]['nama_jurusan'] ?? 'Jurusan '.$idJ }}
                                    </td>
                                    @foreach($kriteria as $k)
                                        <td>{{ number_format($baris[$k->id_kriteria] ?? 0, 3) }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Matriks Ternormalisasi --}}
        <div class="accordion-item border-0 mb-2 rounded-3 overflow-hidden shadow-sm">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseR">
                    <i class="fas fa-compress-arrows-alt me-2" style="color:#0066cc;"></i>
                    Langkah 2 — Matriks Ternormalisasi (r<sub>ij</sub>)
                </button>
            </h2>
            <div id="collapseR" class="accordion-collapse collapse" data-bs-parent="#accordionTopsis">
                <div class="accordion-body p-0">
                    <div class="step-box mx-3 mt-3">
                        <code>r_ij = x_ij / √(Σ x²_ij)</code>
                        <span class="ms-2 text-muted small">Normalisasi vector untuk menyamakan skala</span>
                    </div>
                    <div class="table-responsive px-3 pb-3">
                        <table class="table table-bordered table-sm tbl-matrix mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th>Jurusan</th>
                                    @foreach($kriteria as $k)<th>{{ $k->kode_kriteria }}</th>@endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hasil->matriks_ternormalisasi as $idJ => $baris)
                                <tr>
                                    <td class="fw-semibold" style="white-space:nowrap;">
                                        {{ $hasil->detail_hasil[array_search($idJ, array_column($hasil->detail_hasil, 'id_jurusan'))]['nama_jurusan'] ?? 'J'.$idJ }}
                                    </td>
                                    @foreach($kriteria as $k)
                                        <td><small>{{ number_format($baris[$k->id_kriteria] ?? 0, 5) }}</small></td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Matriks Terbobot --}}
        <div class="accordion-item border-0 mb-2 rounded-3 overflow-hidden shadow-sm">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseY">
                    <i class="fas fa-weight me-2" style="color:#6f42c1;"></i>
                    Langkah 3 — Matriks Terbobot (y<sub>ij</sub>)
                </button>
            </h2>
            <div id="collapseY" class="accordion-collapse collapse" data-bs-parent="#accordionTopsis">
                <div class="accordion-body p-0">
                    <div class="step-box mx-3 mt-3">
                        <code>y_ij = w_j × r_ij</code>
                        <span class="ms-2 text-muted small">Pembobotan berdasarkan tingkat kepentingan kriteria</span>
                    </div>
                    <div class="table-responsive px-3 pb-3">
                        <table class="table table-bordered table-sm tbl-matrix mb-0">
                            <thead style="background:#6f42c1; color:#fff;">
                                <tr>
                                    <th>Jurusan</th>
                                    @foreach($kriteria as $k)<th>{{ $k->kode_kriteria }}</th>@endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hasil->matriks_terbobot as $idJ => $baris)
                                <tr>
                                    <td class="fw-semibold" style="white-space:nowrap;">
                                        {{ $hasil->detail_hasil[array_search($idJ, array_column($hasil->detail_hasil, 'id_jurusan'))]['nama_jurusan'] ?? 'J'.$idJ }}
                                    </td>
                                    @foreach($kriteria as $k)
                                        <td><small>{{ number_format($baris[$k->id_kriteria] ?? 0, 6) }}</small></td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Solusi Ideal --}}
        @if($hasil->solusi_ideal)
        <div class="accordion-item border-0 mb-2 rounded-3 overflow-hidden shadow-sm">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIdeal">
                    <i class="fas fa-bullseye me-2" style="color:#28a745;"></i>
                    Langkah 4 — Solusi Ideal Positif (A⁺) & Negatif (A⁻)
                </button>
            </h2>
            <div id="collapseIdeal" class="accordion-collapse collapse" data-bs-parent="#accordionTopsis">
                <div class="accordion-body">
                    <div class="step-box mb-3">
                        <code>A⁺_j = max(y_ij)</code> jika benefit, <code>min(y_ij)</code> jika cost &nbsp;|&nbsp;
                        <code>A⁻_j = min(y_ij)</code> jika benefit, <code>max(y_ij)</code> jika cost
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm tbl-matrix mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Solusi</th>
                                    @foreach($kriteria as $k)<th>{{ $k->kode_kriteria }}</th>@endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-success"><i class="fas fa-arrow-up me-1"></i>A⁺</td>
                                    @foreach($kriteria as $k)
                                        <td class="text-success small fw-semibold">{{ number_format($hasil->solusi_ideal['positif'][$k->id_kriteria] ?? 0, 6) }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="fw-bold text-danger"><i class="fas fa-arrow-down me-1"></i>A⁻</td>
                                    @foreach($kriteria as $k)
                                        <td class="text-danger small fw-semibold">{{ number_format($hasil->solusi_ideal['negatif'][$k->id_kriteria] ?? 0, 6) }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>{{-- end accordion --}}

    {{-- ── Tombol Aksi ──────────────────────────────────────────── --}}
    <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
        <a href="{{ route('user.hasil.pdf', $hasil->id_hasil) }}"
           class="btn btn-danger px-4 py-2 fw-bold rounded-pill">
            <i class="fas fa-file-pdf me-2"></i>Download PDF
        </a>
        <a href="{{ route('user.kuesioner.index') }}"
           class="btn btn-outline-primary px-4 py-2 fw-bold rounded-pill">
            <i class="fas fa-redo me-2"></i>Ulangi Kuesioner
        </a>
        <a href="{{ route('user.hasil.histori') }}"
           class="btn btn-outline-secondary px-4 py-2 fw-bold rounded-pill">
            <i class="fas fa-history me-2"></i>Lihat Riwayat
        </a>
    </div>

</div>
</div>
@endsection

@section('scripts')
<script>
const chartData = @json(array_slice($hasil->detail_hasil, 0, 10));
const labels    = chartData.map(d => d.nama_jurusan);
const values    = chartData.map(d => d.vi_persen);
const colors    = chartData.map((d, i) =>
    i === 0 ? '#003d80' : i === 1 ? '#0055aa' : i === 2 ? '#0066cc' :
    i < 5   ? '#4d94ff' : '#b3ccff'
);

new Chart(document.getElementById('chartVi'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Nilai Preferensi (%)',
            data: values,
            backgroundColor: colors,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.raw}% (Vi = ${chartData[ctx.dataIndex].vi.toFixed(4)})`
                }
            }
        },
        scales: {
            x: { ticks: { font: { size: 11 } } },
            y: {
                beginAtZero: true,
                max: 100,
                ticks: { callback: v => v + '%', font: { size: 11 } },
                grid: { color: '#f0f0f0' }
            }
        }
    }
});
</script>
@endsection
