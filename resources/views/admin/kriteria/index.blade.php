@extends('layouts.admin')
@section('title','Kriteria & Bobot')
@section('page-title','Manajemen Kriteria & Bobot')
@section('breadcrumb')
    <li class="breadcrumb-item active">Kriteria</li>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="alert alert-info border-0 shadow-sm" style="border-left:4px solid #003d80 !important;">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Tipe Benefit:</strong> semakin tinggi nilainya semakin baik (misal: Minat Matematika).
            &nbsp;<strong>Tipe Cost:</strong> semakin rendah nilainya semakin baik (misal: Biaya Kuliah).
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-sliders-h me-2" style="color:#003d80;"></i>Daftar Kriteria</span>
        <a href="{{ route('admin.kriteria.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Kriteria
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Kode</th><th>Nama Kriteria</th><th>Tipe</th>
                        <th>Bobot</th><th>Bobot (W)</th><th>Urutan</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalBobot = $kriteria->sum('bobot');
                    @endphp
                    @forelse($kriteria as $k)
                    <tr>
                        <td><span class="badge bg-secondary">{{ $k->kode_kriteria }}</span></td>
                        <td>
                            <div class="fw-semibold">{{ $k->nama_kriteria }}</div>
                            @if($k->deskripsi)<small class="text-muted">{{ Str::limit($k->deskripsi, 50) }}</small>@endif
                        </td>
                        <td>
                            <span class="badge {{ $k->tipe=='benefit' ? 'badge-benefit' : 'badge-cost' }} px-2 py-1">
                                <i class="fas {{ $k->tipe=='benefit' ? 'fa-arrow-up' : 'fa-arrow-down' }} me-1"></i>
                                {{ ucfirst($k->tipe) }}
                            </span>
                        </td>
                        <td><strong>{{ $k->bobot }}</strong></td>
                        <td>
                            <small class="text-muted">
                                {{ $totalBobot > 0 ? number_format($k->bobot/$totalBobot, 4) : '0' }}
                            </small>
                        </td>
                        <td>{{ $k->urutan }}</td>
                        <td>
                            <span class="badge {{ $k->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $k->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.kriteria.edit', $k) }}" class="btn btn-xs btn-outline-warning me-1" style="font-size:11px;padding:3px 10px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.kriteria.destroy', $k) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus kriteria {{ $k->nama_kriteria }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-outline-danger" style="font-size:11px;padding:3px 10px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada kriteria</td></tr>
                    @endforelse
                </tbody>
                @if($kriteria->count())
                <tfoot class="table-light">
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total Bobot:</td>
                        <td><strong class="text-primary">{{ $totalBobot }}</strong></td>
                        <td><strong class="text-success">1.0000</strong></td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
