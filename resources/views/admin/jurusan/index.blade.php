@extends('layouts.admin')
@section('title','Manajemen Jurusan')
@section('page-title','Manajemen Jurusan')
@section('breadcrumb')
    <li class="breadcrumb-item active">Jurusan</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-university me-2" style="color:#003d80;"></i>Daftar Jurusan</span>
        <a href="{{ route('admin.jurusan.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Jurusan
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Nama Jurusan</th>
                        <th>Jenjang</th>
                        <th>Fakultas</th>
                        <th>Akreditasi</th>
                        <th>Status</th>
                        <th style="width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurusan as $i => $j)
                    <tr>
                        <td>{{ $jurusan->firstItem() + $i }}</td>
                        <td>
                            <div class="fw-semibold">{{ $j->nama_jurusan }}</div>
                            @if($j->singkatan)<small class="text-muted">{{ $j->singkatan }}</small>@endif
                        </td>
                        <td>
                            <span class="badge {{ $j->jenjang=='S1' ? 'bg-primary' : 'bg-info' }}">
                                {{ $j->jenjang }}
                            </span>
                        </td>
                        <td><small>{{ $j->fakultas }}</small></td>
                        <td>
                            <span class="badge {{ $j->akreditasi=='A'?'bg-success':($j->akreditasi=='B'?'bg-warning text-dark':'bg-secondary') }}">
                                {{ $j->akreditasi }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $j->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $j->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.jurusan.edit', $j) }}" class="btn btn-xs btn-outline-warning me-1" style="font-size:11px;padding:3px 10px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('admin.penilaian.edit', $j) }}" class="btn btn-xs btn-outline-info me-1" style="font-size:11px;padding:3px 10px;" title="Input Nilai">
                                <i class="fas fa-table"></i>
                            </a>
                            <form action="{{ route('admin.jurusan.destroy', $j) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus jurusan {{ $j->nama_jurusan }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-outline-danger" style="font-size:11px;padding:3px 10px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data jurusan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($jurusan->hasPages())
    <div class="card-footer">{{ $jurusan->links() }}</div>
    @endif
</div>
@endsection
