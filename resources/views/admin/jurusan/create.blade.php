@extends('layouts.admin')
@section('title','Tambah Jurusan')
@section('page-title','Tambah Jurusan Baru')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.jurusan.index') }}">Jurusan</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card">
    <div class="card-header">
        <i class="fas fa-plus-circle me-2" style="color:#003d80;"></i>Form Tambah Jurusan
    </div>
    <div class="card-body">
        <form action="{{ route('admin.jurusan.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">Nama Jurusan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_jurusan" class="form-control @error('nama_jurusan') is-invalid @enderror"
                           value="{{ old('nama_jurusan') }}" placeholder="Contoh: Teknik Informatika">
                    @error('nama_jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Singkatan</label>
                    <input type="text" name="singkatan" class="form-control @error('singkatan') is-invalid @enderror"
                           value="{{ old('singkatan') }}" placeholder="TI">
                    @error('singkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Jenjang <span class="text-danger">*</span></label>
                    <select name="jenjang" class="form-select @error('jenjang') is-invalid @enderror">
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="S1" {{ old('jenjang')=='S1'?'selected':'' }}>S1 (Strata 1)</option>
                        <option value="D3" {{ old('jenjang')=='D3'?'selected':'' }}>D3 (Diploma 3)</option>
                    </select>
                    @error('jenjang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Akreditasi</label>
                    <select name="akreditasi" class="form-select">
                        <option value="A" {{ old('akreditasi')=='A'?'selected':'' }}>A (Unggul)</option>
                        <option value="B" {{ old('akreditasi','B')=='B'?'selected':'' }}>B (Baik Sekali)</option>
                        <option value="C" {{ old('akreditasi')=='C'?'selected':'' }}>C (Baik)</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Fakultas <span class="text-danger">*</span></label>
                    <input type="text" name="fakultas" class="form-control @error('fakultas') is-invalid @enderror"
                           value="{{ old('fakultas') }}" placeholder="Contoh: Ilmu Komputer & Teknologi Informasi">
                    @error('fakultas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"
                              placeholder="Deskripsi singkat tentang jurusan ini...">{{ old('deskripsi') }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Jurusan
                </button>
                <a href="{{ route('admin.jurusan.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
