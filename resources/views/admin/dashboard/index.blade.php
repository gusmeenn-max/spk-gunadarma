@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- ── INFO BOXES ─────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="info-box mb-0" style="border-left:4px solid #003d80;">
            <span class="info-box-icon" style="background:#003d80; border-radius:10px 0 0 10px;">
                <i class="fas fa-university"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Jurusan</span>
                <span class="info-box-number fw-bold">{{ $stats['total_jurusan'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="info-box mb-0" style="border-left:4px solid #28a745;">
            <span class="info-box-icon" style="background:#28a745; border-radius:10px 0 0 10px;">
                <i class="fas fa-user-graduate"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Pengguna</span>
                <span class="info-box-number fw-bold">{{ $stats['total_mahasiswa'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="info-box mb-0" style="border-left:4px solid #f5a623;">
            <span class="info-box-icon" style="background:#f5a623; border-radius:10px 0 0 10px;">
                <i class="fas fa-sliders-h"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Kriteria Aktif</span>
                <span class="info-box-number fw-bold">{{ $stats['total_kriteria'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="info-box mb-0" style="border-left:4px solid #6f42c1;">
            <span class="info-box-icon" style="background:#6f42c1; border-radius:10px 0 0 10px;">
                <i class="fas fa-calculator"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Perhitungan</span>
                <span class="info-box-number fw-bold">{{ $stats['total_perhitungan'] }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Grafik Bulanan --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-line me-2" style="color:#003d80;"></i>Grafik Perhitungan per Bulan</span>
            </div>
            <div class="card-body">
                <canvas id="chartBulanan" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Top Jurusan --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-trophy me-2" style="color:#f5a623;"></i>Top Jurusan Direkomendasikan
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($topJurusan as $i => $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold" style="width:24px;color:{{ $i==0?'#f5a623':($i==1?'#adb5bd':($i==2?'#cd7f32':'#6c757d')) }}; font-size:1.1rem;">
                                {{ $i==0?'🥇':($i==1?'🥈':($i==2?'🥉':'#'.($i+1))) }}
                            </span>
                            <div>
                                <div class="fw-semibold small">{{ $item->jurusanRek1?->nama_jurusan ?? '—' }}</div>
                                <small class="text-muted">{{ $item->jurusanRek1?->jenjang }}</small>
                            </div>
                        </div>
                        <span class="badge rounded-pill" style="background:#003d80;">{{ $item->total }}×</span>
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center py-4 small">
                        <i class="fas fa-info-circle me-1"></i>Belum ada data perhitungan
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    {{-- Histori Terbaru --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-history me-2" style="color:#003d80;"></i>Perhitungan Terbaru</span>
                <a href="{{ route('admin.hasil.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No</th><th>Pengguna</th><th>Rekomendasi #1</th>
                                <th>Kecocokan</th><th>Tanggal</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentHasil as $i => $h)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $h->user?->nama_lengkap }}</div>
                                    <small class="text-muted">{{ $h->user?->username }}</small>
                                </td>
                                <td>
                                    @if($h->jurusanRek1)
                                        <span class="badge" style="background:#e8f0fe;color:#003d80;">
                                            {{ $h->jurusanRek1->nama_jurusan }}
                                        </span>
                                    @else — @endif
                                </td>
                                <td>
                                    @php $vi = $h->getPersentaseRek1(); @endphp
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress" style="width:70px;height:8px;">
                                            <div class="progress-bar" style="width:{{ $vi }}%;background:#003d80;"></div>
                                        </div>
                                        <small class="fw-bold">{{ $vi }}%</small>
                                    </div>
                                </td>
                                <td><small class="text-muted">{{ $h->tanggal_hitung->format('d/m/Y H:i') }}</small></td>
                                <td>
                                    <a href="{{ route('admin.hasil.show', $h->id_hasil) }}" class="btn btn-xs btn-outline-info" style="font-size:11px;padding:2px 8px;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data perhitungan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
const monthlyData = @json($monthlyStats);
new Chart(document.getElementById('chartBulanan'), {
    type: 'bar',
    data: {
        labels: monthlyData.map(d => d.bulan),
        datasets: [{
            label: 'Jumlah Perhitungan',
            data: monthlyData.map(d => d.total),
            backgroundColor: 'rgba(0,61,128,.8)',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endsection
