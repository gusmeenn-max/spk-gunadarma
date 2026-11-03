@extends('layouts.admin')
@section('title','Edit Penilaian '.$jurusan->nama_jurusan)
@section('page-title','Edit Nilai: '.$jurusan->nama_jurusan)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.penilaian.index') }}">Matriks Penilaian</a></li>
    <li class="breadcrumb-item active">{{ $jurusan->singkatan ?? $jurusan->nama_jurusan }}</li>
@endsection

@section('content')
<div class="row justify-content-center"><div class="col-lg-9">

<div class="alert alert-info border-0 small mb-3" style="border-left:4px solid #003d80 !important;">
    <i class="fas fa-info-circle me-2"></i>
    Isi nilai standar jurusan <strong>{{ $jurusan->nama_jurusan }}</strong> terhadap setiap kriteria.
    <strong>Skala 1–5:</strong> 1=Sangat Rendah, 2=Rendah, 3=Cukup, 4=Tinggi, 5=Sangat Tinggi.
</div>

<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <span class="badge {{ $jurusan->jenjang=='S1'?'bg-primary':'bg-info' }}">{{ $jurusan->jenjang }}</span>
        <span class="fw-bold">{{ $jurusan->nama_jurusan }}</span>
        <small class="text-muted">— {{ $jurusan->fakultas }}</small>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.penilaian.update', $jurusan) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                @foreach($kriteria as $k)
                @php $existing = $penilaian[$k->id_kriteria] ?? null; @endphp
                <div class="col-md-6">
                    <div class="p-3 rounded-3 border" style="background:#fafafa;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <span class="badge bg-secondary me-1">{{ $k->kode_kriteria }}</span>
                                <strong class="small">{{ $k->nama_kriteria }}</strong>
                                <span class="badge {{ $k->tipe=='benefit'?'badge-benefit':'badge-cost' }} ms-1 px-2" style="font-size:10px;">
                                    {{ $k->tipe=='benefit'?'↑ Benefit':'↓ Cost' }}
                                </span>
                            </div>
                            <span class="small text-muted">Bobot: {{ $k->bobot }}</span>
                        </div>
                        @if($k->deskripsi)
                            <small class="text-muted d-block mb-2">{{ $k->deskripsi }}</small>
                        @endif
                        <div class="d-flex gap-1 flex-wrap">
                            @for($s=1; $s<=5; $s++)
                            <div class="form-check form-check-inline p-0 m-0">
                                <input type="radio" class="btn-check"
                                       name="nilai[{{ $k->id_kriteria }}]"
                                       id="k{{ $k->id_kriteria }}_{{ $s }}"
                                       value="{{ $s }}"
                                       {{ old("nilai.{$k->id_kriteria}", $existing?->nilai ?? '') == $s ? 'checked' : '' }}>
                                <label class="btn btn-sm {{ $s==1?'btn-outline-danger':($s==2?'btn-outline-warning':($s==3?'btn-outline-secondary':($s==4?'btn-outline-success':'btn-outline-primary'))) }}"
                                       for="k{{ $k->id_kriteria }}_{{ $s }}" style="min-width:46px;">
                                    {{ $s }}
                                </label>
                            </div>
                            @endfor
                        </div>
                        @error("nilai.{$k->id_kriteria}")
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <input type="text" name="keterangan[{{ $k->id_kriteria }}]"
                                   class="form-control form-control-sm"
                                   placeholder="Keterangan (opsional)"
                                   value="{{ old("keterangan.{$k->id_kriteria}", $existing?->keterangan) }}">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Semua Nilai
                </button>
                <a href="{{ route('admin.penilaian.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Matriks
                </a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
