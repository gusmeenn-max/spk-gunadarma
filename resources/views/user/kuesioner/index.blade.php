@extends('layouts.app')
@section('title','Kuesioner Pemilihan Jurusan')

@section('extra-css')
<style>
    .question-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,.06);
        margin-bottom: 16px;
        overflow: hidden;
        transition: box-shadow .2s;
    }
    .question-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.1); }
    .question-card .card-header {
        background: linear-gradient(135deg, #003d80, #0055aa);
        color: #fff;
        padding: 12px 20px;
        font-weight: 700;
        font-size: 13px;
    }
    .answer-btn { min-width: 110px; font-weight: 700; font-size: 13px; border-radius: 8px; padding: 8px 12px; }
    .btn-check:checked + .answer-btn-1 { background: #dc3545; color: #fff; border-color: #dc3545; }
    .btn-check:checked + .answer-btn-2 { background: #fd7e14; color: #fff; border-color: #fd7e14; }
    .btn-check:checked + .answer-btn-3 { background: #ffc107; color: #212529; border-color: #ffc107; }
    .btn-check:checked + .answer-btn-4 { background: #20c997; color: #fff; border-color: #20c997; }
    .btn-check:checked + .answer-btn-5 { background: #0d6efd; color: #fff; border-color: #0d6efd; }
    .progress-sticky {
        position: sticky; top: 0; z-index: 100;
        background: #fff;
        padding: 12px 0 8px;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 20px;
    }
    .q-number {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--gunadarma-blue);
        color: #fff; font-weight: 800; font-size: 13px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .scale-legend { font-size: 11px; color: #6c757d; }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
<div class="col-lg-9">

    {{-- Header --}}
    <div class="text-center mb-4">
        <h3 class="fw-bold" style="color:var(--gunadarma-blue);">
            <i class="fas fa-clipboard-list me-2" style="color:var(--gunadarma-gold);"></i>
            Kuesioner Pemilihan Jurusan
        </h3>
        <p class="text-muted">Jawab setiap pertanyaan dengan jujur sesuai minat dan kemampuanmu.
            Sistem akan menghitung jurusan terbaik menggunakan metode <strong>TOPSIS</strong>.</p>
        @php $totalQ = $kuesioner->flatten()->count(); @endphp
        <div class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill"
             style="background:#e8f0fe;">
            <i class="fas fa-list-ol" style="color:var(--gunadarma-blue);"></i>
            <span class="fw-semibold" style="color:var(--gunadarma-blue);">{{ $totalQ }} pertanyaan total</span>
        </div>
    </div>

    {{-- Skala Legend --}}
    <div class="card mb-4" style="border:2px dashed #dee2e6; background:#fafafa;">
        <div class="card-body py-3">
            <div class="fw-bold small mb-2"><i class="fas fa-info-circle me-2" style="color:var(--gunadarma-gold);"></i>Panduan Pengisian Skala:</div>
            <div class="d-flex flex-wrap gap-3">
                <span class="badge px-3 py-2" style="background:#dc3545;">1 = Sangat Rendah / Tidak Minat</span>
                <span class="badge px-3 py-2" style="background:#fd7e14;">2 = Rendah / Kurang Minat</span>
                <span class="badge px-3 py-2" style="background:#ffc107; color:#000;">3 = Cukup / Netral</span>
                <span class="badge px-3 py-2" style="background:#20c997;">4 = Tinggi / Cukup Minat</span>
                <span class="badge px-3 py-2" style="background:#0d6efd;">5 = Sangat Tinggi / Sangat Minat</span>
            </div>
        </div>
    </div>

    @if(!isset($hasData) || $hasData !== false)
    <form action="{{ route('user.kuesioner.proses') }}" method="POST" id="formKuesioner">
        @csrf
        @php $no = 1; @endphp

        @foreach($kriteria as $k)
            @if(isset($kuesioner[$k->id_kriteria]) && $kuesioner[$k->id_kriteria]->count())
            <div class="question-card card">
                <div class="card-header">
                    <i class="fas fa-tag me-2"></i>
                    {{ $k->kode_kriteria }} — {{ $k->nama_kriteria }}
                    <span class="badge ms-2 {{ $k->tipe=='benefit'?'bg-success':'bg-danger' }}" style="font-size:10px;">
                        {{ $k->tipe=='benefit'?'Benefit':'Cost' }}
                    </span>
                    @if($k->deskripsi)
                        <small class="d-block mt-1 text-white-50" style="font-weight:400;">{{ $k->deskripsi }}</small>
                    @endif
                </div>
                <div class="card-body p-4">
                    @foreach($kuesioner[$k->id_kriteria] as $q)
                    <div class="mb-4 {{ !$loop->last ? 'pb-4 border-bottom' : '' }}">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="q-number">{{ $no }}</div>
                            <label class="form-label fw-semibold mb-0" style="line-height:1.5;">
                                {{ $q->pertanyaan }}
                            </label>
                        </div>
                        <div class="d-flex flex-wrap gap-2 ps-5">
                            @foreach([1=>'Sangat Rendah',2=>'Rendah',3=>'Cukup',4=>'Tinggi',5=>'Sangat Tinggi'] as $val => $label)
                            <div>
                                <input type="radio" class="btn-check"
                                       name="jawaban[{{ $q->id_pertanyaan }}]"
                                       id="q{{ $q->id_pertanyaan }}_{{ $val }}"
                                       value="{{ $val }}"
                                       {{ old("jawaban.{$q->id_pertanyaan}") == $val ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary answer-btn answer-btn-{{ $val }}"
                                       for="q{{ $q->id_pertanyaan }}_{{ $val }}">
                                    <span class="fw-bold">{{ $val }}</span>
                                    <span class="d-block scale-legend">{{ $label }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error("jawaban.{$q->id_pertanyaan}")
                            <div class="text-danger small mt-2 ps-5"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    @php $no++ @endphp
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach

        {{-- Submit Button --}}
        <div class="text-center mt-4 mb-5">
            <div class="mb-3">
                <small class="text-muted"><i class="fas fa-shield-alt me-1"></i>Jawaban Anda aman dan hanya digunakan untuk keperluan rekomendasi.</small>
            </div>
            <button type="submit" class="btn btn-lg px-5 py-3 fw-bold text-white" id="btnSubmit"
                    style="background:linear-gradient(135deg,#003d80,#0066cc);border:none;border-radius:50px;font-size:1.1rem;box-shadow:0 4px 20px rgba(0,61,128,.3);">
                <i class="fas fa-calculator me-2"></i>Hitung Rekomendasi Jurusan
            </button>
        </div>
    </form>

    @else
    <div class="alert alert-warning text-center py-5">
        <i class="fas fa-exclamation-triangle fa-3x mb-3 d-block" style="color:#f5a623;"></i>
        <h5 class="fw-bold">Kuesioner Belum Tersedia</h5>
        <p class="text-muted mb-0">Administrator belum mengisi data kuesioner. Silakan hubungi admin.</p>
    </div>
    @endif

</div>
</div>
@endsection

@section('scripts')
<script>
// Progress tracker
document.getElementById('formKuesioner')?.addEventListener('change', function() {
    const total = document.querySelectorAll('input[type="radio"][name^="jawaban"]').length;
    const answered = new Set(
        Array.from(document.querySelectorAll('input[type="radio"][name^="jawaban"]:checked'))
             .map(el => el.name)
    ).size;
    const totalQ = {{ $totalQ }};
    // you can add a progress bar update here if desired
});

// Confirm before submit
document.getElementById('formKuesioner')?.addEventListener('submit', function(e) {
    const totalQ = {{ $totalQ }};
    const answered = new Set(
        Array.from(document.querySelectorAll('input[type="radio"][name^="jawaban"]:checked'))
             .map(el => el.name)
    ).size;
    if (answered < totalQ) {
        if (!confirm(`Anda baru menjawab ${answered} dari ${totalQ} pertanyaan. Lanjutkan?`)) {
            e.preventDefault();
        }
    }
    document.getElementById('btnSubmit').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sedang Menghitung...';
    document.getElementById('btnSubmit').disabled = true;
});
</script>
@endsection
