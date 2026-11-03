@extends('layouts.admin')
@section('title','Matriks Penilaian')
@section('page-title','Matriks Penilaian Jurusan')
@section('breadcrumb')
    <li class="breadcrumb-item active">Matriks Penilaian</li>
@endsection

@section('extra-css')
<style>
    .matrix-table th, .matrix-table td { font-size: 12px; padding: 6px 10px; text-align: center; }
    .matrix-table td:first-child { text-align: left; font-weight: 600; }
    .nilai-cell {
        width: 52px;
        cursor: pointer;
        border-radius: 6px;
        font-weight: 700;
        transition: all .15s;
    }
    .nilai-cell:focus { outline: 2px solid #003d80; box-shadow: none; }
    .nilai-1 { background: #ffe0e0; color: #c62828; }
    .nilai-2 { background: #fff3cd; color: #856404; }
    .nilai-3 { background: #fff9c4; color: #827717; }
    .nilai-4 { background: #d4edda; color: #155724; }
    .nilai-5 { background: #cce5ff; color: #004085; }
    .legend-item { display: inline-flex; align-items: center; gap: 6px; margin-right: 16px; font-size: 12px; }
    .legend-dot { width: 12px; height: 12px; border-radius: 3px; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <p class="text-muted mb-1 small">Klik tombol <strong>Edit</strong> pada baris jurusan untuk mengisi nilai setiap kriteria (skala 1–5).</p>
        <div>
            @foreach([1=>'Sangat Rendah',2=>'Rendah',3=>'Cukup',4=>'Tinggi',5=>'Sangat Tinggi'] as $n=>$l)
            <span class="legend-item">
                <span class="legend-dot nilai-{{ $n }}"></span>{{ $n }} = {{ $l }}
            </span>
            @endforeach
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="fas fa-table me-2" style="color:#003d80;"></i>Matriks Keputusan (Jurusan × Kriteria)</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered matrix-table mb-0">
                <thead class="table-dark">
                    <tr>
                        <th rowspan="2" style="vertical-align:middle; min-width:160px;">Jurusan</th>
                        <th rowspan="2" style="vertical-align:middle;">Jenjang</th>
                        @foreach($kriteria as $k)
                        <th style="min-width:60px;">
                            <div>{{ $k->kode_kriteria }}</div>
                            <small class="text-white-50" style="font-size:9px;font-weight:400;">{{ $k->tipe }}</small>
                        </th>
                        @endforeach
                        <th rowspan="2" style="vertical-align:middle;">Aksi</th>
                    </tr>
                    <tr>
                        @foreach($kriteria as $k)
                        <th style="font-size:9px; font-weight:400; color:rgba(255,255,255,.7); min-width:60px;">
                            W={{ $k->bobot }}
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurusan as $j)
                    <tr>
                        <td>
                            {{ $j->nama_jurusan }}
                            @if($j->singkatan)<small class="text-muted d-block">{{ $j->singkatan }}</small>@endif
                        </td>
                        <td>
                            <span class="badge {{ $j->jenjang=='S1'?'bg-primary':'bg-info' }}">{{ $j->jenjang }}</span>
                        </td>
                        @foreach($kriteria as $k)
                        @php $key = $j->id_jurusan.'_'.$k->id_kriteria; $nilai = $penilaian[$key]->nilai ?? null; @endphp
                        <td>
                            @if($nilai !== null)
                                <span class="badge nilai-{{ (int)$nilai }} px-2 py-1 rounded">{{ $nilai }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        @endforeach
                        <td>
                            <a href="{{ route('admin.penilaian.edit', $j) }}" class="btn btn-xs btn-outline-primary" style="font-size:11px;padding:3px 10px;white-space:nowrap;">
                                <i class="fas fa-edit me-1"></i>Edit Nilai
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
