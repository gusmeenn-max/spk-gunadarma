@extends('layouts.admin')
@section('title','Detail Hasil')
@section('page-title','Detail Hasil Perhitungan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.hasil.index') }}">Monitor Hasil</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection
@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card text-center p-3">
            <div class="text-muted small mb-1">Pengguna</div>
            <div class="fw-bold fs-5" style="color:#003d80;">{{ $hasil->user?->nama_lengkap }}</div>
            <div class="text-muted small">{{ $hasil->user?->username }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center p-3">
            <div class="text-muted small mb-1">Tanggal Hitung</div>
            <div class="fw-bold">{{ $hasil->tanggal_hitung->format('d F Y, H:i') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center p-3">
            <div class="text-muted small mb-1">Rekomendasi Utama</div>
            <div class="fw-bold" style="color:#f5a623;">{{ $hasil->jurusanRek1?->nama_jurusan }}</div>
            <div class="fw-bold fs-4" style="color:#003d80;">{{ $hasil->getPersentaseRek1() }}%</div>
        </div>
    </div>
</div>

{{-- Ranking Lengkap --}}
<div class="card mb-4">
    <div class="card-header"><i class="fas fa-table me-2" style="color:#003d80;"></i>Tabel Ranking Lengkap</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Rank</th><th>Jurusan</th><th>Jenjang</th>
                        <th>D⁺</th><th>D⁻</th><th>V_i</th><th>Kecocokan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hasil->detail_hasil as $r)
                    <tr class="{{ $r['peringkat']<=3?'table-warning':'' }}">
                        <td><strong>{{ $r['peringkat'] }}</strong></td>
                        <td class="fw-semibold">{{ $r['nama_jurusan'] }}</td>
                        <td><span class="badge {{ $r['jenjang']=='S1'?'bg-primary':'bg-info' }}">{{ $r['jenjang'] }}</span></td>
                        <td><code>{{ number_format($r['d_plus'],4) }}</code></td>
                        <td><code>{{ number_format($r['d_minus'],4) }}</code></td>
                        <td><strong>{{ number_format($r['vi'],4) }}</strong></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress" style="width:80px;height:8px;">
                                    <div class="progress-bar" style="width:{{ $r['vi_persen'] }}%;background:#003d80;"></div>
                                </div>
                                <small>{{ $r['vi_persen'] }}%</small>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Solusi Ideal --}}
@if($hasil->solusi_ideal)
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-success fw-bold"><i class="fas fa-arrow-up me-2"></i>Solusi Ideal Positif (A⁺)</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <tbody>
                            @foreach($hasil->solusi_ideal['positif'] as $idK => $val)
                            <tr>
                                <td class="text-muted small">Kriteria {{ $idK }}</td>
                                <td><code>{{ number_format($val, 6) }}</code></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-danger fw-bold"><i class="fas fa-arrow-down me-2"></i>Solusi Ideal Negatif (A⁻)</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <tbody>
                            @foreach($hasil->solusi_ideal['negatif'] as $idK => $val)
                            <tr>
                                <td class="text-muted small">Kriteria {{ $idK }}</td>
                                <td><code>{{ number_format($val, 6) }}</code></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<a href="{{ route('admin.hasil.index') }}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
@endsection
