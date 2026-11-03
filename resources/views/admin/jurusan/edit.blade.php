@extends('layouts.admin')
@section('title', 'Edit Jurusan')
@section('page-title', 'Edit Jurusan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.jurusan.index') }}">Jurusan</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2" style="color:#003d80;"></i>Edit: {{ $jurusan->nama_jurusan }}
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jurusan.update', $jurusan) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Nama Jurusan <span class="text-danger">*</span></label>
                                <input type="text" name="nama_jurusan"
                                    class="form-control @error('nama_jurusan') is-invalid @enderror"
                                    value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}">
                                @error('nama_jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Singkatan</label>
                                <input type="text" name="singkatan" class="form-control"
                                    value="{{ old('singkatan', $jurusan->singkatan) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jenjang <span class="text-danger">*</span></label>
                                <select name="jenjang" class="form-select @error('jenjang') is-invalid @enderror">
                                    <option value="S1"
                                        {{ old('jenjang', $jurusan->jenjang) == 'S1' ? 'selected' : '' }}>S1
                                    </option>
                                    <option value="D3"
                                        {{ old('jenjang', $jurusan->jenjang) == 'D3' ? 'selected' : '' }}>D3
                                    </option>
                                </select>
                                @error('jenjang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Akreditasi</label>
                                <select name="akreditasi" class="form-select">
                                    @foreach (['A', 'B', 'C'] as $ak)
                                        <option value="{{ $ak }}"
                                            {{ old('akreditasi', $jurusan->akreditasi) == $ak ? 'selected' : '' }}>
                                            {{ $ak }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Fakultas <span class="text-danger">*</span></label>
                                <input type="text" name="fakultas"
                                    class="form-control @error('fakultas') is-invalid @enderror"
                                    value="{{ old('fakultas', $jurusan->fakultas) }}">
                                @error('fakultas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                                        value="1" {{ old('is_active', $jurusan->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="isActive">Jurusan Aktif</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Jurusan
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
