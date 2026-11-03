@extends('layouts.admin')
@section('title','Tambah Pertanyaan')
@section('page-title','Tambah Pertanyaan Kuesioner')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.kuesioner.index') }}">Kuesioner</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection
@section('content')
<div class="row justify-content-center"><div class="col-lg-7">
<div class="card">
    <div class="card-header"><i class="fas fa-plus-circle me-2" style="color:#003d80;"></i>Form Tambah Pertanyaan</div>
    <div class="card-body">
        <form action="{{ route('admin.kuesioner.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Kriteria <span class="text-danger">*</span></label>
                <select name="id_kriteria" class="form-select @error('id_kriteria') is-invalid @enderror">
                    <option value="">-- Pilih Kriteria --</option>
                    @foreach($kriteria as $k)
                    <option value="{{ $k->id_kriteria }}" {{ old('id_kriteria')==$k->id_kriteria?'selected':'' }}>
                        [{{ $k->kode_kriteria }}] {{ $k->nama_kriteria }}
                    </option>
                    @endforeach
                </select>
                @error('id_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Pertanyaan <span class="text-danger">*</span></label>
                <textarea name="pertanyaan" class="form-control @error('pertanyaan') is-invalid @enderror"
                          rows="3" placeholder="Tulis pertanyaan kuesioner...">{{ old('pertanyaan') }}</textarea>
                @error('pertanyaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tipe Jawaban</label>
                    <select name="tipe_jawaban" class="form-select">
                        <option value="skala" {{ old('tipe_jawaban','skala')=='skala'?'selected':'' }}>Skala 1–5</option>
                        <option value="ya_tidak" {{ old('tipe_jawaban')=='ya_tidak'?'selected':'' }}>Ya / Tidak</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Urutan</label>
                    <input type="number" name="urutan" min="0" class="form-control"
                           value="{{ old('urutan', $nextUrutan) }}">
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
                <a href="{{ route('admin.kuesioner.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times me-2"></i>Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
