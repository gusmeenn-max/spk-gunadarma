@extends('layouts.admin')
@section('title','Monitor Hasil SPK')
@section('page-title','Monitor Hasil Perhitungan SPK')
@section('breadcrumb')
    <li class="breadcrumb-item active">Monitor Hasil</li>
@endsection
@section('content')

{{-- Statistik Jurusan --}}
@if($statJurusan->count())
<div class="card mb-4">
    <div class="card-header"><i class="fas fa-trophy me-2" style="color:#f5a623;"></i>Statistik: Jurusan Paling Direkomendasikan</div>
    <div class="card-body pb-2">
        <div class="row g-2">
            @foreach($statJurusan->take(5) as $i => $s)
            <div class="col-md-auto">
                <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:#f8f9fa;border:1px solid #e9ecef;">
                    <span style="font-size:1.2rem;">{{ $i==0?'🥇':($i==1?'🥈':($i==2?'🥉':'#'.($i+1))) }}</span>
                    <div>
                        <div class="fw-bold small" style="color:#003d80;">
                            {{ $s->jurusanRek1?->nama_jurusan ?? '—' }}
                        </div>
                        <small class="text-muted">{{ $s->total }}× direkomendasikan</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="fas fa-list me-2" style="color:#003d80;"></i>Riwayat Semua Perhitungan</span>
        <form action="" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" style="width:200px;"
                   placeholder="Cari nama/username..." value="{{ request('search') }}">
            <button class="btn btn-sm btn-outline-primary">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.hasil.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            @endif
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th><th>Pengguna</th>
                        <th>Rek. #1</th><th>Rek. #2</th><th>Rek. #3</th>
                        <th>Kecocokan #1</th><th>Tanggal</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hasil as $i => $h)
                    <tr>
                        <td>{{ $hasil->firstItem() + $i }}</td>
                        <td>
                            <div class="fw-semibold">{{ $h->user?->nama_lengkap }}</div>
                            <small class="text-muted">{{ $h->user?->username }}</small>
                        </td>
                        <td>
                            @if($h->jurusanRek1)
                            <span class="badge px-2 py-1" style="background:#e8f0fe;color:#003d80;font-size:11px;">
                                {{ $h->jurusanRek1->nama_jurusan }}
                            </span>
                            @endif
                        </td>
                        <td>
                            @if($h->jurusanRek2)
                            <span class="badge bg-light text-dark px-2 py-1" style="font-size:11px;">
                                {{ $h->jurusanRek2->nama_jurusan }}
                            </span>
                            @endif
                        </td>
                        <td>
                            @if($h->jurusanRek3)
                            <span class="badge bg-light text-dark px-2 py-1" style="font-size:11px;">
                                {{ $h->jurusanRek3->nama_jurusan }}
                            </span>
                            @endif
                        </td>
                        <td>
                            @php $vi = $h->getPersentaseRek1(); @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:8px;min-width:60px;">
                                    <div class="progress-bar" style="width:{{ $vi }}%;background:#003d80;"></div>
                                </div>
                                <small class="fw-bold">{{ $vi }}%</small>
                            </div>
                        </td>
                        <td><small>{{ $h->tanggal_hitung->format('d/m/Y H:i') }}</small></td>
                        <td>
                            <a href="{{ route('admin.hasil.show', $h->id_hasil) }}" class="btn btn-xs btn-outline-info me-1" style="font-size:11px;padding:3px 8px;">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.hasil.destroy', $h->id_hasil) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus data hasil ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-outline-danger" style="font-size:11px;padding:3px 8px;"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data perhitungan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($hasil->hasPages())
    <div class="card-footer">{{ $hasil->links() }}</div>
    @endif
</div>
@endsection
