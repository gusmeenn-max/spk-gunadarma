<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::orderBy('jenjang')->orderBy('nama_jurusan')->paginate(15);
        return view('admin.jurusan.index', compact('jurusan'));
    }

    public function create()
    {
        return view('admin.jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:100',
            'jenjang'      => 'required|in:D3,S1',
            'fakultas'     => 'required|string|max:100',
            'singkatan'    => 'nullable|string|max:20',
            'deskripsi'    => 'nullable|string',
            'akreditasi'   => 'nullable|string|max:5',
        ]);

        Jurusan::create($request->only([
            'nama_jurusan', 'jenjang', 'fakultas', 'singkatan', 'deskripsi', 'akreditasi'
        ]));

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan!');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:100',
            'jenjang'      => 'required|in:D3,S1',
            'fakultas'     => 'required|string|max:100',
            'singkatan'    => 'nullable|string|max:20',
            'deskripsi'    => 'nullable|string',
            'akreditasi'   => 'nullable|string|max:5',
            'is_active'    => 'boolean',
        ]);

        $jurusan->update($request->only([
            'nama_jurusan', 'jenjang', 'fakultas', 'singkatan', 'deskripsi', 'akreditasi'
        ]));
        $jurusan->is_active = $request->has('is_active');
        $jurusan->save();

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data jurusan berhasil diperbarui!');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}
