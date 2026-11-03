@extends('layouts.admin')
@section('title','Kelola Kuesioner')
@section('page-title','Kelola Kuesioner')
@section('breadcrumb')
    <li class="breadcrumb-item active">Kuesioner</li>
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-question-circle me-2" style="color:#003d80;"></i>Daftar Pertanyaan Kuesioner</span>
        <a href="{{ route('admin.kuesioner.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Pertanyaan
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th><th>Pertanyaan</th><th>Kriteria</th>
                    <th>Tipe Jawaban</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kuesioner as $i => $q)
                <tr>
                    <td>{{ $kuesioner->firstItem() + $i }}</td>
                    <td style="max-width:400px;">{{ $q->pertanyaan }}</td>
                    <td>
                        <span class="badge bg-secondary">{{ $q->kriteria?->kode_kriteria }}</span>
                        <small class="text-muted ms-1">{{ $q->kriteria?->nama_kriteria }}</small>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $q->tipe_jawaban == 'skala' ? 'Skala 1–5' : 'Ya/Tidak' }}
                        </span>
                    </td>
                    <td><span class="badge {{ $q->is_active?'bg-success':'bg-secondary' }}">{{ $q->is_active?'Aktif':'Nonaktif' }}</span></td>
                    <td>
                        <a href="{{ route('admin.kuesioner.edit', $q) }}" class="btn btn-xs btn-outline-warning me-1" style="font-size:11px;padding:3px 8px;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.kuesioner.destroy', $q) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus pertanyaan ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-xs btn-outline-danger" style="font-size:11px;padding:3px 8px;"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pertanyaan kuesioner</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kuesioner->hasPages())
    <div class="card-footer">{{ $kuesioner->links() }}</div>
    @endif
</div>
@endsection
