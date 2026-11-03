@extends('layouts.admin')
@section('title','Edit Pertanyaan')
@section('page-title','Edit Pertanyaan Kuesioner')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.kuesioner.index') }}">Kuesioner</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="row justify-content-center"><div class="col-lg-7">
<div class="card">
    <div class="card-header"><i class="fas fa-edit me-2" style="color:#003d80;"></i>Edit Pertanyaan</div>
    <div class="card-body">
        <form action="{{ route('admin.kuesioner.update', $kuesioner) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">Kriteria <span class="text-danger">*</span></label>
                <select name="id_kriteria" class="form-select @error('id_kriteria') is-invalid @enderror">
                    @foreach($kriteria as $k)
                    <option value="{{ $k->id_kriteria }}" {{ old('id_kriteria',$kuesioner->id_kriteria)==$k->id_kriteria?'selected':'' }}>
                        [{{ $k->kode_kriteria }}] {{ $k->nama_kriteria }}
                    </option>
                    @endforeach
                </select>
                @error('id_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Pertanyaan <span class="text-danger">*</span></label>
                <textarea name="pertanyaan" class="form-control @error('pertanyaan') is-invalid @enderror"
                          rows="3">{{ old('pertanyaan', $kuesioner->pertanyaan) }}</textarea>
                @error('pertanyaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tipe Jawaban</label>
                    <select name="tipe_jawaban" class="form-select">
                        <option value="skala"    {{ old('tipe_jawaban',$kuesioner->tipe_jawaban)=='skala'?'selected':'' }}>Skala 1–5</option>
                        <option value="ya_tidak" {{ old('tipe_jawaban',$kuesioner->tipe_jawaban)=='ya_tidak'?'selected':'' }}>Ya / Tidak</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Urutan</label>
                    <input type="number" name="urutan" min="0" class="form-control"
                           value="{{ old('urutan', $kuesioner->urutan) }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                               {{ old('is_active', $kuesioner->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold small" for="isActive">Aktif</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button>
                <a href="{{ route('admin.kuesioner.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times me-2"></i>Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
