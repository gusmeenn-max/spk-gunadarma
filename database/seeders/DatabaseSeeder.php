<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Kriteria;
use App\Models\Kuesioner;
use App\Models\PenilaianJurusan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. USERS ─────────────────────────────────────────────────────────
        User::create([
            'username'     => 'admin',
            'password'     => Hash::make('admin123'),
            'nama_lengkap' => 'Administrator SPK',
            'email'        => 'admin@gunadarma.ac.id',
            'role'         => 'admin',
        ]);

        User::create([
            'username'     => 'demo',
            'password'     => Hash::make('demo123'),
            'nama_lengkap' => 'Mahasiswa Demo',
            'email'        => 'demo@student.gunadarma.ac.id',
            'role'         => 'mahasiswa',
            'nim'          => '10001001',
            'asal_sekolah' => 'SMA Negeri 1 Jakarta',
        ]);

        // ── 2. JURUSAN ────────────────────────────────────────────────────────
        $jurusanData = [
            // S1 — Ilmu Komputer & TI
            ['Sistem Informasi',       'S1', 'Ilmu Komputer & Teknologi Informasi', 'SI',   'A', 'Mempelajari pengelolaan informasi dan pengembangan sistem berbasis komputer.'],
            ['Teknik Informatika',     'S1', 'Ilmu Komputer & Teknologi Informasi', 'TI',   'A', 'Berfokus pada pengembangan software, algoritma, dan ilmu komputer mendalam.'],
            ['Sistem Komputer',        'S1', 'Ilmu Komputer & Teknologi Informasi', 'SK',   'B', 'Menggabungkan hardware dan software dalam perancangan sistem komputer.'],
            // S1 — Teknologi Industri
            ['Teknik Elektro',         'S1', 'Teknologi Industri', 'TE',   'A', 'Mempelajari sistem kelistrikan, elektronika, dan otomasi industri.'],
            ['Teknik Mesin',           'S1', 'Teknologi Industri', 'TM',   'B', 'Perancangan dan manufaktur mesin serta sistem mekanikal.'],
            ['Teknik Industri',        'S1', 'Teknologi Industri', 'TInd', 'B', 'Optimasi sistem produksi, manajemen operasional, dan rekayasa sistem.'],
            // S1 — Teknik Sipil & Perencanaan
            ['Teknik Sipil',           'S1', 'Teknik Sipil & Perencanaan', 'TS',   'B', 'Perancangan dan konstruksi infrastruktur seperti jembatan dan gedung.'],
            ['Arsitektur',             'S1', 'Teknik Sipil & Perencanaan', 'ARS',  'B', 'Desain ruang dan bangunan yang fungsional sekaligus estetis.'],
            // S1 — Ekonomi
            ['Manajemen',              'S1', 'Ekonomi', 'MNJ', 'A', 'Pengelolaan organisasi, sumber daya manusia, dan strategi bisnis.'],
            ['Akuntansi',              'S1', 'Ekonomi', 'AKT', 'A', 'Pencatatan, pelaporan, dan analisis keuangan perusahaan.'],
            ['Ekonomi Pembangunan',    'S1', 'Ekonomi', 'EP',  'B', 'Analisis kebijakan ekonomi, pembangunan nasional, dan keuangan publik.'],
            // S1 — Non-teknik
            ['Psikologi',              'S1', 'Psikologi', 'PSI', 'B', 'Memahami perilaku manusia, konseling, dan psikologi industri.'],
            ['Sastra Inggris',         'S1', 'Sastra', 'SIng', 'B', 'Kajian linguistik, sastra, dan penerjemahan bahasa Inggris.'],
            ['Ilmu Komunikasi',        'S1', 'Ilmu Komunikasi & Media', 'KOM', 'B', 'Strategi komunikasi, jurnalistik, PR, dan media massa.'],
            // D3
            ['Kebidanan',              'D3', 'Kesehatan', 'KEB',  'B', 'Pelayanan kesehatan ibu dan anak serta asuhan kebidanan.'],
            ['Manajemen Informatika',  'D3', 'Ilmu Komputer & Teknologi Informasi', 'MI', 'B', 'Terapan teknologi informasi untuk kebutuhan bisnis dan instansi.'],
            ['Teknik Komputer',        'D3', 'Ilmu Komputer & Teknologi Informasi', 'TK', 'B', 'Perakitan, troubleshooting, dan jaringan komputer terapan.'],
            ['Akuntansi Komputer',     'D3', 'Ekonomi', 'AKK', 'B', 'Akuntansi berbasis komputer dan aplikasi keuangan digital.'],
            ['Pemasaran',              'D3', 'Ekonomi', 'PM',  'B', 'Strategi pemasaran digital, riset pasar, dan manajemen produk.'],
            ['Administrasi Perkantoran','D3','Ekonomi', 'AP',  'B', 'Manajemen administrasi, kesekretariatan, dan tata kelola kantor.'],
        ];

        foreach ($jurusanData as $j) {
            Jurusan::create([
                'nama_jurusan' => $j[0],
                'jenjang'      => $j[1],
                'fakultas'     => $j[2],
                'singkatan'    => $j[3],
                'akreditasi'   => $j[4],
                'deskripsi'    => $j[5],
            ]);
        }

        // ── 3. KRITERIA ───────────────────────────────────────────────────────
        $kriteriaData = [
            //  kode  nama                           tipe       bobot  deskripsi                                              urutan
            ['C1', 'Minat Teknologi & Komputer',    'benefit',  5,   'Seberapa besar minat terhadap dunia komputer & IT',      1],
            ['C2', 'Kemampuan Matematika',           'benefit',  4,   'Nilai & kemampuan di bidang matematika dan logika',      2],
            ['C3', 'Kemampuan Bahasa Inggris',       'benefit',  3,   'Kemampuan membaca, menulis, dan berbicara bahasa Inggris',3],
            ['C4', 'Minat Bisnis & Ekonomi',         'benefit',  4,   'Ketertarikan terhadap dunia bisnis, keuangan, wirausaha', 4],
            ['C5', 'Kemampuan Analitis & Logika',    'benefit',  4,   'Kemampuan berpikir analitis dan pemecahan masalah',       5],
            ['C6', 'Minat Seni & Desain',            'benefit',  2,   'Ketertarikan di bidang seni visual, desain, arsitektur',  6],
            ['C7', 'Pertimbangan Biaya Kuliah',      'cost',     3,   'Faktor biaya (cost: semakin rendah semakin disukai)',     7],
            ['C8', 'Minat Sosial & Komunikasi',      'benefit',  3,   'Kemampuan bersosialisasi dan minat komunikasi publik',    8],
        ];

        foreach ($kriteriaData as $k) {
            Kriteria::create([
                'kode_kriteria' => $k[0],
                'nama_kriteria' => $k[1],
                'tipe'          => $k[2],
                'bobot'         => $k[3],
                'deskripsi'     => $k[4],
                'urutan'        => $k[5],
            ]);
        }

        // ── 4. KUESIONER ─────────────────────────────────────────────────────
        $kuesionerData = [
            // [id_kriteria, pertanyaan, urutan]
            [1, 'Seberapa besar minat Anda terhadap pemrograman dan pengembangan software?', 1],
            [1, 'Apakah Anda sering menggunakan teknologi untuk menyelesaikan masalah sehari-hari?', 2],
            [2, 'Bagaimana nilai matematika Anda sewaktu SMA/SMK?', 3],
            [2, 'Seberapa nyaman Anda mengerjakan soal-soal logika dan perhitungan?', 4],
            [3, 'Bagaimana kemampuan membaca dan memahami teks bahasa Inggris Anda?', 5],
            [3, 'Apakah Anda terbiasa menggunakan referensi atau konten berbahasa Inggris?', 6],
            [4, 'Seberapa besar minat Anda terhadap dunia bisnis dan kewirausahaan?', 7],
            [4, 'Apakah Anda tertarik mempelajari laporan keuangan dan manajemen organisasi?', 8],
            [5, 'Seberapa baik kemampuan Anda dalam menganalisis suatu permasalahan secara sistematis?', 9],
            [5, 'Apakah Anda menikmati teka-teki logika, pemecahan masalah, atau debat ilmiah?', 10],
            [6, 'Seberapa besar ketertarikan Anda terhadap seni, desain grafis, atau arsitektur?', 11],
            [7, 'Seberapa besar kemampuan finansial keluarga Anda dalam membiayai kuliah (1=sangat terbatas, 5=sangat memadai)?', 12],
            [8, 'Apakah Anda senang berbicara di depan umum, berdiskusi, atau berorganisasi?', 13],
            [8, 'Seberapa besar minat Anda di bidang komunikasi, hubungan masyarakat, atau media?', 14],
        ];

        foreach ($kuesionerData as $q) {
            Kuesioner::create([
                'id_kriteria'  => $q[0],
                'pertanyaan'   => $q[1],
                'urutan'       => $q[2],
                'tipe_jawaban' => 'skala',
            ]);
        }

        // ── 5. PENILAIAN JURUSAN (Matriks Keputusan Awal) ────────────────────
        // Format: [id_jurusan, C1, C2, C3, C4, C5, C6, C7_cost, C8]
        // Nilai skala 1–5
        $matriks = [
            //  id  C1  C2  C3  C4  C5  C6  C7  C8
            [  1,   5,  4,  4,  3,  4,  2,  3,  3 ],  // Sistem Informasi
            [  2,   5,  5,  4,  2,  5,  2,  3,  2 ],  // Teknik Informatika
            [  3,   5,  5,  3,  2,  5,  2,  3,  2 ],  // Sistem Komputer
            [  4,   4,  5,  3,  2,  5,  3,  3,  2 ],  // Teknik Elektro
            [  5,   3,  5,  3,  2,  4,  3,  3,  2 ],  // Teknik Mesin
            [  6,   3,  4,  3,  4,  5,  3,  3,  3 ],  // Teknik Industri
            [  7,   3,  4,  3,  2,  4,  4,  3,  2 ],  // Teknik Sipil
            [  8,   2,  3,  3,  2,  3,  5,  4,  3 ],  // Arsitektur
            [  9,   2,  3,  4,  5,  4,  2,  4,  5 ],  // Manajemen
            [ 10,   2,  5,  3,  5,  5,  1,  4,  3 ],  // Akuntansi
            [ 11,   2,  4,  4,  5,  4,  1,  3,  4 ],  // Ekonomi Pembangunan
            [ 12,   2,  2,  4,  3,  4,  3,  3,  5 ],  // Psikologi
            [ 13,   1,  2,  5,  3,  3,  4,  2,  4 ],  // Sastra Inggris
            [ 14,   2,  2,  4,  4,  3,  4,  3,  5 ],  // Ilmu Komunikasi
            [ 15,   1,  3,  3,  2,  4,  2,  3,  5 ],  // Kebidanan D3
            [ 16,   4,  3,  3,  3,  4,  2,  2,  3 ],  // Manajemen Informatika D3
            [ 17,   5,  4,  3,  2,  4,  2,  2,  2 ],  // Teknik Komputer D3
            [ 18,   3,  4,  3,  4,  4,  1,  2,  3 ],  // Akuntansi Komputer D3
            [ 19,   2,  2,  4,  5,  3,  3,  2,  5 ],  // Pemasaran D3
            [ 20,   1,  2,  4,  4,  3,  2,  2,  5 ],  // Administrasi Perkantoran D3
        ];

        foreach ($matriks as $row) {
            $idJurusan = $row[0];
            for ($col = 1; $col <= 8; $col++) {
                PenilaianJurusan::create([
                    'id_jurusan'  => $idJurusan,
                    'id_kriteria' => $col,         // C1=1, C2=2, … C8=8
                    'nilai'       => $row[$col],
                ]);
            }
        }
    }
}
