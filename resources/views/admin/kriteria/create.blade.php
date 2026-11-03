@extends('layouts.admin')
@section('title','Tambah Kriteria')
@section('page-title','Tambah Kriteria')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.kriteria.index') }}">Kriteria</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection
@section('content')
<div class="row justify-content-center"><div class="col-lg-7">
<div class="card">
    <div class="card-header"><i class="fas fa-plus-circle me-2" style="color:#003d80;"></i>Form Tambah Kriteria</div>
    <div class="card-body">
        <form action="{{ route('admin.kriteria.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Kode Kriteria</label>
                    <input type="text" name="kode_kriteria" class="form-control @error('kode_kriteria') is-invalid @enderror"
                           value="{{ old('kode_kriteria', $nextKode) }}" placeholder="C1">
                    @error('kode_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Nama Kriteria <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kriteria" class="form-control @error('nama_kriteria') is-invalid @enderror"
                           value="{{ old('nama_kriteria') }}" placeholder="Contoh: Minat Matematika">
                    @error('nama_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tipe <span class="text-danger">*</span></label>
                    <select name="tipe" class="form-select @error('tipe') is-invalid @enderror">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="benefit" {{ old('tipe')=='benefit'?'selected':'' }}>Benefit (↑ semakin baik)</option>
                        <option value="cost"    {{ old('tipe')=='cost'?'selected':'' }}>Cost (↓ semakin baik)</option>
                    </select>
                    @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Bobot <span class="text-danger">*</span></label>
                    <input type="number" name="bobot" step="0.5" min="0.5" max="10"
                           class="form-control @error('bobot') is-invalid @enderror"
                           value="{{ old('bobot', 3) }}">
                    @error('bobot')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Urutan</label>
                    <input type="number" name="urutan" min="0" class="form-control"
                           value="{{ old('urutan', $nextUrutan) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="2"
                              placeholder="Penjelasan singkat kriteria ini...">{{ old('deskripsi') }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
                <a href="{{ route('admin.kriteria.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times me-2"></i>Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
