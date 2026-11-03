@extends('layouts.app')
@section('title', 'Riwayat Perhitungan')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-10">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color:var(--gunadarma-blue);">
                <i class="fas fa-history me-2" style="color:var(--gunadarma-gold);"></i>
                Riwayat Perhitungan
            </h4>
            <p class="text-muted mb-0 small">Semua hasil kuesioner yang pernah kamu lakukan.</p>
        </div>
        <a href="{{ route('user.kuesioner.index') }}" class="btn btn-primary-spk">
            <i class="fas fa-plus me-2"></i>Kuesioner Baru
        </a>
    </div>

    @forelse($histori as $h)
    <div class="card-spk card mb-3">
        <div class="card-body p-4">
            <div class="row align-items-center">
                {{-- Rekomendasi Top 3 --}}
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $h->tanggal_hitung->format('d F Y, H:i') }} WIB
                        </small>
                        <span class="badge bg-light text-dark border" style="font-size:10px;">#{{ $h->id_hasil }}</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @if($h->jurusanRek1)
                        <div class="px-3 py-2 rounded-3 d-flex align-items-center gap-2"
                             style="background:#fff3cd; border:1px solid #ffc107;">
                            <span>🥇</span>
                            <div>
                                <div class="fw-bold" style="font-size:13px; color:#003d80;">{{ $h->jurusanRek1->nama_jurusan }}</div>
                                <small class="text-muted">{{ $h->jurusanRek1->jenjang }} — {{ $h->getPersentaseRek1() }}%</small>
                            </div>
                        </div>
                        @endif
                        @if($h->jurusanRek2)
                        <div class="px-3 py-2 rounded-3 d-flex align-items-center gap-2"
                             style="background:#f8f9fa; border:1px solid #dee2e6;">
                            <span>🥈</span>
                            <div>
                                <div class="fw-semibold" style="font-size:12px; color:#495057;">{{ $h->jurusanRek2->nama_jurusan }}</div>
                                <small class="text-muted">{{ $h->jurusanRek2->jenjang }}</small>
                            </div>
                        </div>
                        @endif
                        @if($h->jurusanRek3)
                        <div class="px-3 py-2 rounded-3 d-flex align-items-center gap-2"
                             style="background:#f8f9fa; border:1px solid #dee2e6;">
                            <span>🥉</span>
                            <div>
                                <div class="fw-semibold" style="font-size:12px; color:#495057;">{{ $h->jurusanRek3->nama_jurusan }}</div>
                                <small class="text-muted">{{ $h->jurusanRek3->jenjang }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                {{-- Tombol Aksi --}}
                <div class="col-md-4 mt-3 mt-md-0 d-flex gap-2 justify-content-md-end flex-wrap">
                    <a href="{{ route('user.hasil.show', $h->id_hasil) }}"
                       class="btn btn-sm fw-bold px-3 rounded-pill"
                       style="background:#003d80; color:#fff; border:none;">
                        <i class="fas fa-eye me-1"></i>Detail
                    </a>
                    <a href="{{ route('user.hasil.pdf', $h->id_hasil) }}"
                       class="btn btn-sm btn-outline-danger fw-bold px-3 rounded-pill">
                        <i class="fas fa-file-pdf me-1"></i>PDF
                    </a>
                    <form action="{{ route('user.hasil.hapus', $h->id_hasil) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus riwayat ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <div style="font-size:4rem; margin-bottom:16px;">📋</div>
        <h5 class="fw-bold" style="color:#003d80;">Belum Ada Riwayat</h5>
        <p class="text-muted mb-4">Kamu belum pernah mengisi kuesioner. Mulai sekarang untuk mendapatkan rekomendasi jurusan!</p>
        <a href="{{ route('user.kuesioner.index') }}" class="btn btn-primary-spk">
            <i class="fas fa-play me-2"></i>Mulai Kuesioner Sekarang
        </a>
    </div>
    @endforelse

    @if($histori->hasPages())
    <div class="mt-3">{{ $histori->links() }}</div>
    @endif

</div>
</div>
@endsection
