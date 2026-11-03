<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\PenilaianController;
use App\Http\Controllers\Admin\KuesionerController as AdminKuesionerController;
use App\Http\Controllers\Admin\HasilMonitorController;
use App\Http\Controllers\Admin\UserManageController;
use App\Http\Controllers\User\KuesionerController;
use App\Http\Controllers\User\HasilController;
use Illuminate\Support\Facades\Route;

// ─── Landing Page ──────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ─── DEBUG TOPSIS (hapus setelah selesai testing) ──────────────────────────
Route::get('/debug-topsis', function() {
    $topsis = new App\Services\TopsisService();
    $input = [1=>5, 2=>5, 3=>2.5, 4=>1, 5=>3, 6=>2, 7=>4, 8=>1];
    $result = $topsis->hitung($input);
    return collect($result['ranking'])->map(fn($r) => [
        'rank'    => $r['peringkat'],
        'jurusan' => $r['nama_jurusan'],
        'vi'      => $r['vi_persen'].'%'
    ]);
});

// ─── Authentication ────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ─── Admin Routes ──────────────────────────────────────────────────────────
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('jurusan', JurusanController::class)->except(['show']);
    Route::resource('kriteria', KriteriaController::class)->except(['show']);

    Route::get('/penilaian',                [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/{jurusan}/edit', [PenilaianController::class, 'editJurusan'])->name('penilaian.edit');
    Route::put('/penilaian/{jurusan}',      [PenilaianController::class, 'updateJurusan'])->name('penilaian.update');
    Route::post('/penilaian/bulk',          [PenilaianController::class, 'bulkStore'])->name('penilaian.bulk');

    Route::resource('kuesioner', AdminKuesionerController::class)->except(['show']);

    Route::get('/hasil',            [HasilMonitorController::class, 'index'])->name('hasil.index');
    Route::get('/hasil/{hasil}',    [HasilMonitorController::class, 'show'])->name('hasil.show');
    Route::delete('/hasil/{hasil}', [HasilMonitorController::class, 'destroy'])->name('hasil.destroy');

    Route::get('/users',                [UserManageController::class, 'index'])->name('users.index');
    Route::get('/users/create',         [UserManageController::class, 'create'])->name('users.create');
    Route::post('/users',               [UserManageController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}',      [UserManageController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/reset',  [UserManageController::class, 'resetPassword'])->name('users.reset');
});

// ─── User (Mahasiswa) Routes ───────────────────────────────────────────────
Route::get('/dashboard', [KuesionerController::class, 'dashboard'])->name('dashboard');

Route::prefix('user')
    ->name('user.')
    ->middleware(['auth', 'role:mahasiswa'])
    ->group(function () {

    Route::get('/kuesioner',         [KuesionerController::class, 'index'])->name('kuesioner.index');
    Route::post('/kuesioner/proses', [KuesionerController::class, 'proses'])->name('kuesioner.proses');
    Route::get('/hasil/proses',      [KuesionerController::class, 'hasilProses'])->name('hasil.proses');

    Route::get('/hasil/{id}',        [HasilController::class, 'show'])->name('hasil.show');
    Route::get('/hasil/{id}/pdf',    [HasilController::class, 'cetakPdf'])->name('hasil.pdf');
    Route::delete('/hasil/{id}',     [HasilController::class, 'hapus'])->name('hasil.hapus');

    Route::get('/histori',           [HasilController::class, 'histori'])->name('hasil.histori');
});