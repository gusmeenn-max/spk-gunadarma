<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kriteria;
use App\Models\PenilaianJurusan;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * Tampilkan matriks penilaian (tabel jurusan × kriteria)
     */
    public function index()
    {
        $jurusan  = Jurusan::active()->orderBy('jenjang')->orderBy('nama_jurusan')->get();
        $kriteria = Kriteria::active()->get();

        // Buat lookup table untuk akses cepat
        $penilaian = PenilaianJurusan::all()
            ->keyBy(fn($p) => $p->id_jurusan . '_' . $p->id_kriteria);

        return view('admin.penilaian.index', compact('jurusan', 'kriteria', 'penilaian'));
    }

    /**
     * Form penilaian untuk satu jurusan (semua kriteria)
     */
    public function editJurusan(Jurusan $jurusan)
    {
        $kriteria  = Kriteria::active()->get();
        $penilaian = PenilaianJurusan::where('id_jurusan', $jurusan->id_jurusan)
            ->get()->keyBy('id_kriteria');

        return view('admin.penilaian.edit-jurusan', compact('jurusan', 'kriteria', 'penilaian'));
    }

    /**
     * Simpan penilaian untuk satu jurusan (bulk update)
     */
    public function updateJurusan(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nilai'   => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:5',
        ]);

        foreach ($request->nilai as $idKriteria => $nilai) {
            PenilaianJurusan::updateOrCreate(
                [
                    'id_jurusan'  => $jurusan->id_jurusan,
                    'id_kriteria' => $idKriteria,
                ],
                [
                    'nilai'      => $nilai,
                    'keterangan' => $request->keterangan[$idKriteria] ?? null,
                ]
            );
        }

        return redirect()->route('admin.penilaian.index')
            ->with('success', "Penilaian untuk {$jurusan->nama_jurusan} berhasil disimpan!");
    }

    /**
     * Simpan dari bulk input matriks (AJAX)
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'data'          => 'required|array',
            'data.*.id_jurusan'  => 'required|exists:jurusan,id_jurusan',
            'data.*.id_kriteria' => 'required|exists:kriteria,id_kriteria',
            'data.*.nilai'       => 'required|numeric|min:0|max:5',
        ]);

        foreach ($request->data as $item) {
            PenilaianJurusan::updateOrCreate(
                [
                    'id_jurusan'  => $item['id_jurusan'],
                    'id_kriteria' => $item['id_kriteria'],
                ],
                ['nilai' => $item['nilai']]
            );
        }

        return response()->json(['success' => true, 'message' => 'Data penilaian berhasil disimpan.']);
    }
}
