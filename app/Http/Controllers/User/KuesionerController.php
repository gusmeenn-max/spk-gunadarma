<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kuesioner;
use App\Models\Kriteria;
use App\Models\Hasil;
use App\Services\TopsisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuesionerController extends Controller
{
    public function dashboard()
{
    $riwayatTerakhir = \App\Models\Hasil::where('id_user', auth()->id())
        ->orderByDesc('tanggal_hitung')
        ->limit(3)
        ->get();

    $totalHasil = \App\Models\Hasil::where('id_user', auth()->id())->count();

    return view('user.dashboard_mahasiswa', compact('riwayatTerakhir', 'totalHasil'));
}
    public function index()
    {
        $kuesioner = Kuesioner::with('kriteria')
            ->active()
            ->get()
            ->groupBy('id_kriteria');

        $kriteria = Kriteria::active()->get();

        if ($kriteria->isEmpty()) {
            return view('user.kuesioner.index', [
                'kuesioner'  => collect(),
                'kriteria'   => collect(),
                'hasData'    => false,
            ]);
        }

        // Histori terakhir user (opsional, untuk ditampilkan)
        $lastHasil = Auth::check()
            ? Hasil::where('id_user', Auth::id())->latest('tanggal_hitung')->first()
            : null;

        return view('user.kuesioner.index', compact('kuesioner', 'kriteria', 'lastHasil'));
    }

    public function proses(Request $request)
    {
        // Validasi semua pertanyaan aktif harus dijawab
        $pertanyaanAktif = Kuesioner::active()->pluck('id_pertanyaan')->toArray();

        $rules = [];
        foreach ($pertanyaanAktif as $id) {
            $rules["jawaban.{$id}"] = 'required|integer|min:1|max:5';
        }
        $request->validate($rules, [
            'jawaban.*.required' => 'Semua pertanyaan harus dijawab.',
            'jawaban.*.min'      => 'Pilih jawaban antara 1-5.',
            'jawaban.*.max'      => 'Pilih jawaban antara 1-5.',
        ]);

        // Agregasi: Rata-rata jawaban per kriteria
        $kuesionerList   = Kuesioner::active()->get();
        $inputPerKriteria = [];

        foreach ($kuesionerList as $q) {
            $jawaban = $request->jawaban[$q->id_pertanyaan] ?? 3;
            if (!isset($inputPerKriteria[$q->id_kriteria])) {
                $inputPerKriteria[$q->id_kriteria] = [];
            }
            $inputPerKriteria[$q->id_kriteria][] = $jawaban;
        }

        // Rata-rata per kriteria
        $inputUser = [];
        foreach ($inputPerKriteria as $idKriteria => $nilaiList) {
            $inputUser[$idKriteria] = array_sum($nilaiList) / count($nilaiList);
        }

        // Simpan ke session untuk halaman proses
        session(['topsis_input' => $inputUser, 'topsis_raw_jawaban' => $request->jawaban]);

        return redirect()->route('user.hasil.proses');
    }

    public function hasilProses(TopsisService $topsis)
    {
        $inputUser = session('topsis_input');

        if (!$inputUser) {
            return redirect()->route('user.kuesioner.index')
                ->with('error', 'Silakan isi kuesioner terlebih dahulu.');
        }

        try {
            // Jalankan perhitungan TOPSIS
            $result = $topsis->hitung($inputUser);

            // Simpan ke database
            $ranking   = $result['ranking'];
            $idUser    = Auth::id();

            $hasil = Hasil::create([
                'id_user'               => $idUser,
                'input_kuesioner'       => session('topsis_raw_jawaban'),
                'detail_hasil'          => $ranking,
                'matriks_keputusan'     => $result['matriks_keputusan'],
                'matriks_ternormalisasi'=> $result['matriks_ternormalisasi'],
                'matriks_terbobot'      => $result['matriks_terbobot'],
                'solusi_ideal'          => $result['solusi_ideal'],
                'jurusan_rekomendasi_1' => $ranking[0]['id_jurusan'] ?? null,
                'jurusan_rekomendasi_2' => $ranking[1]['id_jurusan'] ?? null,
                'jurusan_rekomendasi_3' => $ranking[2]['id_jurusan'] ?? null,
            ]);

            // Bersihkan session
            session()->forget(['topsis_input', 'topsis_raw_jawaban']);

            return redirect()->route('user.hasil.show', $hasil->id_hasil);

        } catch (\Exception $e) {
            return redirect()->route('user.kuesioner.index')
                ->with('error', 'Terjadi kesalahan saat menghitung: ' . $e->getMessage());
        }
    }
}
