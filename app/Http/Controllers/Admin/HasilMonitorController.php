<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hasil;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class HasilMonitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Hasil::with(['user', 'jurusanRek1', 'jurusanRek2', 'jurusanRek3'])
            ->orderByDesc('tanggal_hitung');

        if ($request->search) {
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$request->search}%")
                ->orWhere('username', 'like', "%{$request->search}%"));
        }

        $hasil = $query->paginate(15)->withQueryString();

        // Statistik rekomendasi jurusan
        $statJurusan = Hasil::selectRaw('jurusan_rekomendasi_1 as id_jurusan, COUNT(*) as total')
            ->whereNotNull('jurusan_rekomendasi_1')
            ->groupBy('jurusan_rekomendasi_1')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('admin.hasil.index', compact('hasil', 'statJurusan'));
    }

    public function show(Hasil $hasil)
    {
        $hasil->load(['user', 'jurusanRek1', 'jurusanRek2', 'jurusanRek3']);
        return view('admin.hasil.show', compact('hasil'));
    }

    public function destroy(Hasil $hasil)
    {
        $hasil->delete();
        return redirect()->route('admin.hasil.index')
            ->with('success', 'Data hasil dihapus.');
    }
}
