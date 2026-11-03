<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuesioner;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KuesionerController extends Controller
{
    public function index()
    {
        $kuesioner = Kuesioner::with('kriteria')->orderBy('urutan')->paginate(20);
        return view('admin.kuesioner.index', compact('kuesioner'));
    }

    public function create()
    {
        $kriteria   = Kriteria::active()->get();
        $nextUrutan = Kuesioner::max('urutan') + 1;
        return view('admin.kuesioner.create', compact('kriteria', 'nextUrutan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kriteria'  => 'required|exists:kriteria,id_kriteria',
            'pertanyaan'   => 'required|string',
            'tipe_jawaban' => 'required|in:skala,ya_tidak',
            'urutan'       => 'nullable|integer|min:0',
        ]);

        Kuesioner::create($request->only(['id_kriteria', 'pertanyaan', 'tipe_jawaban', 'urutan']));

        return redirect()->route('admin.kuesioner.index')
            ->with('success', 'Pertanyaan kuesioner berhasil ditambahkan!');
    }

    public function edit(Kuesioner $kuesioner)
    {
        $kriteria = Kriteria::active()->get();
        return view('admin.kuesioner.edit', compact('kuesioner', 'kriteria'));
    }

    public function update(Request $request, Kuesioner $kuesioner)
    {
        $request->validate([
            'id_kriteria'  => 'required|exists:kriteria,id_kriteria',
            'pertanyaan'   => 'required|string',
            'tipe_jawaban' => 'required|in:skala,ya_tidak',
            'urutan'       => 'nullable|integer|min:0',
            'is_active'    => 'boolean',
        ]);

        $kuesioner->update($request->only(['id_kriteria', 'pertanyaan', 'tipe_jawaban', 'urutan']));
        $kuesioner->is_active = $request->has('is_active');
        $kuesioner->save();

        return redirect()->route('admin.kuesioner.index')
            ->with('success', 'Pertanyaan kuesioner berhasil diperbarui!');
    }

    public function destroy(Kuesioner $kuesioner)
    {
        $kuesioner->delete();
        return redirect()->route('admin.kuesioner.index')
            ->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
