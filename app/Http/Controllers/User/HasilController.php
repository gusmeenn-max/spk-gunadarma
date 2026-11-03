<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Hasil;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilController extends Controller
{
    public function show($id)
    {
        $hasil = Hasil::where('id_hasil', $id)
            ->where('id_user', Auth::id())
            ->with(['jurusanRek1', 'jurusanRek2', 'jurusanRek3', 'user'])
            ->firstOrFail();

        $kriteria = Kriteria::active()->get();

        return view('user.hasil.show', compact('hasil', 'kriteria'));
    }

    public function histori()
    {
        $histori = Hasil::where('id_user', Auth::id())
            ->with(['jurusanRek1', 'jurusanRek2', 'jurusanRek3'])
            ->orderByDesc('tanggal_hitung')
            ->paginate(10);

        return view('user.hasil.histori', compact('histori'));
    }

    public function cetakPdf($id)
    {
        $hasil = Hasil::where('id_hasil', $id)
            ->where('id_user', Auth::id())
            ->with(['jurusanRek1', 'jurusanRek2', 'jurusanRek3', 'user'])
            ->firstOrFail();

        $kriteria = Kriteria::active()->get();

        $pdf = Pdf::loadView('user.hasil.pdf', compact('hasil', 'kriteria'))
            ->setPaper('a4', 'portrait');

        $filename = 'hasil-spk-' . $hasil->user->username . '-' . $hasil->tanggal_hitung->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    public function hapus($id)
    {
        Hasil::where('id_hasil', $id)->where('id_user', Auth::id())->delete();
        return redirect()->route('user.hasil.histori')->with('success', 'Riwayat berhasil dihapus.');
    }
}
