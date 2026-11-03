<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::orderBy('urutan')->paginate(15);
        return view('admin.kriteria.index', compact('kriteria'));
    }

    public function create()
    {
        $nextUrutan = Kriteria::max('urutan') + 1;
        $nextKode   = 'C' . ($nextUrutan);
        return view('admin.kriteria.create', compact('nextUrutan', 'nextKode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:100',
            'kode_kriteria' => 'nullable|string|max:10|unique:kriteria,kode_kriteria',
            'bobot'         => 'required|numeric|min:0.01|max:10',
            'tipe'          => 'required|in:benefit,cost',
            'deskripsi'     => 'nullable|string',
            'urutan'        => 'nullable|integer|min:0',
        ]);

        Kriteria::create($request->only([
            'nama_kriteria', 'kode_kriteria', 'bobot', 'tipe', 'deskripsi', 'urutan'
        ]));

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan!');
    }

    public function edit(Kriteria $kriteria)
    {
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:100',
            'kode_kriteria' => 'nullable|string|max:10|unique:kriteria,kode_kriteria,' . $kriteria->id_kriteria . ',id_kriteria',
            'bobot'         => 'required|numeric|min:0.01|max:10',
            'tipe'          => 'required|in:benefit,cost',
            'deskripsi'     => 'nullable|string',
            'urutan'        => 'nullable|integer|min:0',
            'is_active'     => 'boolean',
        ]);

        $kriteria->update($request->only([
            'nama_kriteria', 'kode_kriteria', 'bobot', 'tipe', 'deskripsi', 'urutan'
        ]));
        $kriteria->is_active = $request->has('is_active');
        $kriteria->save();

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil diperbarui!');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();
        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil dihapus.');
    }
}
