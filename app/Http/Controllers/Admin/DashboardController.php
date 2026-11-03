<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Jurusan, Kriteria, User, Hasil};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_jurusan'     => Jurusan::count(),
            'total_mahasiswa'   => User::where('role','mahasiswa')->count(),
            'total_kriteria'    => Kriteria::where('is_active',true)->count(),
            'total_perhitungan' => Hasil::count(),
        ];
        $topJurusan = Hasil::selectRaw('jurusan_rekomendasi_1 as id_jurusan, COUNT(*) as total')
            ->whereNotNull('jurusan_rekomendasi_1')
            ->groupBy('jurusan_rekomendasi_1')
            ->orderByDesc('total')->limit(5)->with('jurusanRek1')->get();
        $recentHasil = Hasil::with(['user','jurusanRek1'])
            ->orderByDesc('tanggal_hitung')->limit(10)->get();
        $monthlyStats = Hasil::selectRaw('DATE_FORMAT(tanggal_hitung, "%Y-%m") as bulan, COUNT(*) as total')
            ->groupBy('bulan')->orderBy('bulan')->limit(6)->get();
        return view('admin.dashboard.index', compact('stats','topJurusan','recentHasil','monthlyStats'));
    }
}
