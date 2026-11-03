<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil SPK — {{ $hasil->user->nama_lengkap }}</title>
    <style>
        * { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; margin: 0; padding: 0; }
        body { padding: 20px; color: #212529; }

        .header { text-align: center; border-bottom: 3px solid #003d80; padding-bottom: 14px; margin-bottom: 20px; }
        .header h1 { font-size: 16px; color: #003d80; font-weight: bold; }
        .header h2 { font-size: 13px; color: #003d80; font-weight: bold; }
        .header p  { font-size: 10px; color: #666; margin-top: 4px; }

        .info-box { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px 16px; margin-bottom: 18px; }
        .info-row { display: table; width: 100%; margin-bottom: 4px; }
        .info-label { display: table-cell; width: 130px; font-weight: bold; color: #495057; }
        .info-value { display: table-cell; color: #212529; }

        .section-title {
            background: #003d80; color: #fff;
            padding: 7px 12px; font-weight: bold; font-size: 11px;
            margin-bottom: 0; margin-top: 16px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 0; }
        th { background: #003d80; color: #fff; padding: 6px 8px; font-size: 10px; text-align: center; }
        td { padding: 5px 8px; border-bottom: 1px solid #dee2e6; font-size: 10px; }
        tr:nth-child(even) td { background: #f8f9fa; }
        tr.top1 td { background: #fff3cd; font-weight: bold; }
        tr.top3 td { background: #f0f4ff; }

        .rekomendasi-box {
            border: 2px solid #003d80; border-radius: 8px;
            padding: 16px; text-align: center; margin-bottom: 18px;
            background: #f0f4ff;
        }
        .rekomendasi-box h3 { color: #003d80; font-size: 15px; margin-bottom: 4px; }
        .rekomendasi-box .persen { font-size: 28px; font-weight: bold; color: #f5a623; }

        .top3-grid { display: table; width: 100%; margin-bottom: 18px; }
        .top3-cell { display: table-cell; width: 33.3%; padding: 6px; vertical-align: top; }
        .top3-inner { border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; text-align: center; background: #fff; }
        .top3-inner .rank { font-size: 18px; }
        .top3-inner .jurusan { font-weight: bold; color: #003d80; font-size: 11px; margin-top: 4px; }
        .top3-inner .persen { font-size: 16px; font-weight: bold; color: #f5a623; }

        .footer { margin-top: 30px; border-top: 1px solid #dee2e6; padding-top: 10px; text-align: center; color: #6c757d; font-size: 9px; }
        .badge-benefit { background: #d4edda; color: #155724; padding: 2px 6px; border-radius: 3px; }
        .badge-cost    { background: #f8d7da; color: #721c24; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    <h1>SISTEM PENDUKUNG KEPUTUSAN PEMILIHAN JURUSAN</h1>
    <h2>Universitas Gunadarma — Metode TOPSIS</h2>
    <p>Technique for Order of Preference by Similarity to Ideal Solution</p>
</div>

{{-- INFO PENGGUNA --}}
<div class="info-box">
    <div class="info-row">
        <span class="info-label">Nama Lengkap</span>
        <span class="info-value">: {{ $hasil->user->nama_lengkap }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Username</span>
        <span class="info-value">: {{ $hasil->user->username }}</span>
    </div>
    @if($hasil->user->nim)
    <div class="info-row">
        <span class="info-label">NIM</span>
        <span class="info-value">: {{ $hasil->user->nim }}</span>
    </div>
    @endif
    @if($hasil->user->asal_sekolah)
    <div class="info-row">
        <span class="info-label">Asal Sekolah</span>
        <span class="info-value">: {{ $hasil->user->asal_sekolah }}</span>
    </div>
    @endif
    <div class="info-row">
        <span class="info-label">Tanggal Hitung</span>
        <span class="info-value">: {{ $hasil->tanggal_hitung->format('d F Y, H:i') }} WIB</span>
    </div>
</div>

{{-- REKOMENDASI UTAMA --}}
@if(!empty($hasil->detail_hasil[0]))
@php $top = $hasil->detail_hasil[0]; @endphp
<div class="rekomendasi-box">
    <p style="font-size:10px; color:#666; margin-bottom:4px;">REKOMENDASI UTAMA</p>
    <h3>🎓 {{ $top['nama_jurusan'] }}</h3>
    <p style="font-size:10px; color:#666;">{{ $top['jenjang'] }} — {{ $top['fakultas'] }}</p>
    <div class="persen">{{ $top['vi_persen'] }}%</div>
    <p style="font-size:9px; color:#666;">Tingkat Kecocokan (V<sub>i</sub> = {{ number_format($top['vi'],4) }})</p>
</div>
@endif

{{-- TOP 3 --}}
<div class="top3-grid">
    @foreach(array_slice($hasil->detail_hasil, 0, 3) as $i => $r)
    <div class="top3-cell">
        <div class="top3-inner">
            <div class="rank">{{ $i==0?'🥇':($i==1?'🥈':'🥉') }}</div>
            <div class="jurusan">{{ $r['nama_jurusan'] }}</div>
            <div style="font-size:9px; color:#666;">{{ $r['jenjang'] }}</div>
            <div class="persen">{{ $r['vi_persen'] }}%</div>
        </div>
    </div>
    @endforeach
</div>

{{-- TABEL RANKING LENGKAP --}}
<div class="section-title">TABEL RANKING LENGKAP (Seluruh Jurusan)</div>
<table>
    <thead>
        <tr>
            <th style="width:30px;">Rank</th>
            <th style="text-align:left;">Nama Jurusan</th>
            <th style="width:35px;">Jnjg</th>
            <th style="width:65px;">D⁺</th>
            <th style="width:65px;">D⁻</th>
            <th style="width:55px;">V_i</th>
            <th style="width:55px;">%</th>
        </tr>
    </thead>
    <tbody>
        @foreach($hasil->detail_hasil as $r)
        <tr class="{{ $r['peringkat']==1 ? 'top1' : ($r['peringkat']<=3 ? 'top3' : '') }}">
            <td style="text-align:center;">{{ $r['peringkat'] }}</td>
            <td>{{ $r['nama_jurusan'] }}</td>
            <td style="text-align:center;">{{ $r['jenjang'] }}</td>
            <td style="text-align:right;">{{ number_format($r['d_plus'],4) }}</td>
            <td style="text-align:right;">{{ number_format($r['d_minus'],4) }}</td>
            <td style="text-align:right; font-weight:bold;">{{ number_format($r['vi'],4) }}</td>
            <td style="text-align:right; font-weight:bold;">{{ $r['vi_persen'] }}%</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- KRITERIA YANG DIGUNAKAN --}}
<div class="section-title" style="margin-top:18px;">KRITERIA YANG DIGUNAKAN</div>
<table>
    <thead>
        <tr>
            <th style="width:40px;">Kode</th>
            <th style="text-align:left;">Nama Kriteria</th>
            <th style="width:60px;">Tipe</th>
            <th style="width:50px;">Bobot</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kriteria as $k)
        <tr>
            <td style="text-align:center;">{{ $k->kode_kriteria }}</td>
            <td>{{ $k->nama_kriteria }}</td>
            <td style="text-align:center;">
                <span class="{{ $k->tipe=='benefit'?'badge-benefit':'badge-cost' }}">{{ ucfirst($k->tipe) }}</span>
            </td>
            <td style="text-align:center;">{{ $k->bobot }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- SOLUSI IDEAL --}}
@if($hasil->solusi_ideal)
<div class="section-title" style="margin-top:18px;">SOLUSI IDEAL POSITIF (A⁺) DAN NEGATIF (A⁻)</div>
<table>
    <thead>
        <tr>
            <th>Solusi</th>
            @foreach($kriteria as $k)<th>{{ $k->kode_kriteria }}</th>@endforeach
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="font-weight:bold; color:#155724;">A⁺ (Positif)</td>
            @foreach($kriteria as $k)
                <td style="text-align:right;">{{ number_format($hasil->solusi_ideal['positif'][$k->id_kriteria] ?? 0, 5) }}</td>
            @endforeach
        </tr>
        <tr>
            <td style="font-weight:bold; color:#721c24;">A⁻ (Negatif)</td>
            @foreach($kriteria as $k)
                <td style="text-align:right;">{{ number_format($hasil->solusi_ideal['negatif'][$k->id_kriteria] ?? 0, 5) }}</td>
            @endforeach
        </tr>
    </tbody>
</table>
@endif

<div class="footer">
    <p>Dokumen ini digenerate secara otomatis oleh Sistem Pendukung Keputusan Pemilihan Jurusan</p>
    <p>Universitas Gunadarma &mdash; Metode TOPSIS (Hwang & Yoon, 1981) &mdash; {{ now()->format('d/m/Y H:i') }}</p>
    <p>Hasil ini bersifat rekomendasi dan tidak mengikat. Keputusan akhir tetap ada pada calon mahasiswa.</p>
</div>

</body>
</html>
