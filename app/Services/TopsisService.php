<?php

namespace App\Services;

use App\Models\Jurusan;
use App\Models\Kriteria;
use App\Models\PenilaianJurusan;

/**
 * =====================================================================
 * TOPSIS ENGINE — Sistem Pendukung Keputusan Pemilihan Jurusan
 * Metode: Technique for Order of Preference by Similarity to Ideal Solution
 * =====================================================================
 *
 * PERBAIKAN (v2):
 * - Matriks keputusan X diisi langsung dari penilaian_jurusan (nilai standar
 *   tiap jurusan per kriteria), BUKAN dikalikan input user.
 * - Input user digunakan untuk MEMODIFIKASI BOBOT kriteria, sehingga kriteria
 *   yang lebih dipentingkan user mendapat bobot lebih besar.
 * - Dengan cara ini, jika user lebih suka "matematika", jurusan yang kuat
 *   di kriteria itu akan terangkat nilainya — hasil berbeda tiap user.
 *
 * Referensi Rumus:
 * Hwang, C.L.; Yoon, K. (1981). Multiple Attribute Decision Making.
 */
class TopsisService
{
    private array $jurusanList    = [];
    private array $kriteriaList   = [];
    private array $matriksX       = [];   // Matriks keputusan asli
    private array $matriksR       = [];   // Matriks ternormalisasi
    private array $matriksY       = [];   // Matriks terbobot
    private array $idealPositif   = [];   // A+
    private array $idealNegatif   = [];   // A-
    private array $jarakPlus      = [];   // D+
    private array $jarakMinus     = [];   // D-
    private array $nilaiPreferensi = [];  // Vi
    private array $bobotFinal     = [];   // Bobot akhir (admin × user)

    /**
     * Titik masuk utama.
     * @param array $inputUser  [id_kriteria => rata_rata_jawaban_user (1-5)]
     * @return array Hasil lengkap perhitungan TOPSIS
     */
    public function hitung(array $inputUser): array
    {
        $this->kriteriaList = Kriteria::active()->get()->keyBy('id_kriteria')->toArray();
        $this->jurusanList  = Jurusan::active()->get()->keyBy('id_jurusan')->toArray();

        if (empty($this->kriteriaList) || empty($this->jurusanList)) {
            throw new \Exception('Data kriteria atau jurusan belum tersedia. Hubungi administrator.');
        }

        // Step 1: Bangun Matriks Keputusan dari penilaian standar jurusan
        $this->buildMatriksKeputusan();

        // Step 2: Normalisasi
        $this->normalisasiMatriks();

        // Step 3: Pembobotan — bobot admin dimodifikasi oleh preferensi user
        $this->bobotkanMatriks($inputUser);

        // Step 4: Solusi Ideal
        $this->tentukaSolusiIdeal();

        // Step 5: Jarak
        $this->hitungJarak();

        // Step 6 & 7: Preferensi & Ranking
        $ranking = $this->hitungPreferensiDanRanking();

        return [
            'ranking'                => $ranking,
            'matriks_keputusan'      => $this->matriksX,
            'matriks_ternormalisasi' => $this->matriksR,
            'matriks_terbobot'       => $this->matriksY,
            'bobot_final'            => $this->bobotFinal,
            'solusi_ideal'           => [
                'positif' => $this->idealPositif,
                'negatif' => $this->idealNegatif,
            ],
            'jarak'                  => [
                'plus'  => $this->jarakPlus,
                'minus' => $this->jarakMinus,
            ],
            'nilai_preferensi'       => $this->nilaiPreferensi,
            'jurusan_list'           => $this->jurusanList,
            'kriteria_list'          => $this->kriteriaList,
        ];
    }

    /**
     * STEP 1: Bangun Matriks Keputusan X dari penilaian standar jurusan.
     *
     * Matriks X[i][j] = nilai standar jurusan-i pada kriteria-j
     * (diisi oleh admin di panel penilaian_jurusan, skala bebas mis. 1-5).
     *
     * CATATAN PENTING untuk Admin:
     * Setiap jurusan HARUS memiliki nilai yang BERBEDA antar jurusan
     * pada setidaknya beberapa kriteria, agar TOPSIS bisa membedakannya.
     * Contoh: Sistem Informasi unggul di "Pemrograman" tapi lebih rendah
     * di "Akuntansi", sedangkan Akuntansi sebaliknya.
     */
    private function buildMatriksKeputusan(): void
    {
        $penilaianDB = PenilaianJurusan::all()->groupBy('id_jurusan');

        foreach ($this->jurusanList as $idJurusan => $jurusan) {
            $this->matriksX[$idJurusan] = [];

            foreach ($this->kriteriaList as $idKriteria => $kriteria) {
                $nilaiStandar = 0;
                if (isset($penilaianDB[$idJurusan])) {
                    foreach ($penilaianDB[$idJurusan] as $p) {
                        if ($p->id_kriteria == $idKriteria) {
                            $nilaiStandar = (float) $p->nilai;
                            break;
                        }
                    }
                }
                $this->matriksX[$idJurusan][$idKriteria] = round($nilaiStandar, 4);
            }
        }
    }

    /**
     * STEP 2: Normalisasi Matriks (Vector Normalization)
     *
     * r_ij = x_ij / sqrt(Σ_i(x_ij²))
     */
    private function normalisasiMatriks(): void
    {
        $normFaktor = [];
        foreach ($this->kriteriaList as $idKriteria => $kriteria) {
            $sumKuadrat = 0;
            foreach ($this->jurusanList as $idJurusan => $jurusan) {
                $sumKuadrat += pow($this->matriksX[$idJurusan][$idKriteria] ?? 0, 2);
            }
            $normFaktor[$idKriteria] = sqrt($sumKuadrat);
        }

        foreach ($this->jurusanList as $idJurusan => $jurusan) {
            $this->matriksR[$idJurusan] = [];
            foreach ($this->kriteriaList as $idKriteria => $kriteria) {
                $xij    = $this->matriksX[$idJurusan][$idKriteria] ?? 0;
                $faktor = $normFaktor[$idKriteria];
                $this->matriksR[$idJurusan][$idKriteria] = $faktor > 0
                    ? round($xij / $faktor, 6)
                    : 0;
            }
        }
    }

    /**
     * STEP 3: Pembobotan Matriks dengan bobot yang dipengaruhi preferensi user.
     *
     * Formula bobot akhir:
     *   bobot_user_j     = nilaiUser[j] / 5        (normalisasi ke 0-1)
     *   bobot_gabungan_j = bobot_admin_j × bobot_user_j
     *   w_j (final)      = bobot_gabungan_j / Σ(bobot_gabungan)
     *
     * Efek: Kriteria yang user beri nilai tinggi (5) mendapat bobot lebih besar,
     * sehingga jurusan yang unggul di kriteria itu akan terdorong ke peringkat atas.
     * Kriteria yang user beri nilai rendah (1) bobotnya mengecil (tapi tidak nol).
     *
     * @param array $inputUser [id_kriteria => rata_rata_jawaban (1-5)]
     */
    private function bobotkanMatriks(array $inputUser): void
    {
        // Hitung bobot gabungan: bobot admin × preferensi user
        $bobotGabungan = [];
        foreach ($this->kriteriaList as $idKriteria => $kriteria) {
            $bobotAdmin = (float) $kriteria['bobot'];
            // Gunakan nilai user; default 3 (tengah) jika tidak ada jawaban
            $nilaiUser  = isset($inputUser[$idKriteria]) ? (float) $inputUser[$idKriteria] : 3.0;
            // Normalisasi user ke 0-1 (skala 1-5 → 0.2-1.0)
            $faktorUser = $nilaiUser / 5.0;
            $bobotGabungan[$idKriteria] = $bobotAdmin * $faktorUser;
        }

        // Normalisasi total bobot gabungan = 1
        $totalBobot = array_sum($bobotGabungan);
        foreach ($bobotGabungan as $idKriteria => $b) {
            $this->bobotFinal[$idKriteria] = $totalBobot > 0 ? round($b / $totalBobot, 6) : 0;
        }

        // Terapkan ke matriks terbobot: y_ij = w_j × r_ij
        foreach ($this->jurusanList as $idJurusan => $jurusan) {
            $this->matriksY[$idJurusan] = [];
            foreach ($this->kriteriaList as $idKriteria => $kriteria) {
                $rij = $this->matriksR[$idJurusan][$idKriteria] ?? 0;
                $this->matriksY[$idJurusan][$idKriteria] = round($this->bobotFinal[$idKriteria] * $rij, 6);
            }
        }
    }

    /**
     * STEP 4: Tentukan Solusi Ideal Positif (A+) dan Negatif (A-)
     *
     * A+[j] = max(y_ij) jika benefit, min(y_ij) jika cost
     * A-[j] = min(y_ij) jika benefit, max(y_ij) jika cost
     */
    private function tentukaSolusiIdeal(): void
    {
        foreach ($this->kriteriaList as $idKriteria => $kriteria) {
            $kolomValues = [];
            foreach ($this->jurusanList as $idJurusan => $jurusan) {
                $kolomValues[$idJurusan] = $this->matriksY[$idJurusan][$idKriteria] ?? 0;
            }

            $maxVal = max($kolomValues);
            $minVal = min($kolomValues);

            if ($kriteria['tipe'] === 'benefit') {
                $this->idealPositif[$idKriteria] = $maxVal;
                $this->idealNegatif[$idKriteria] = $minVal;
            } else {
                // Cost: semakin kecil semakin baik
                $this->idealPositif[$idKriteria] = $minVal;
                $this->idealNegatif[$idKriteria] = $maxVal;
            }
        }
    }

    /**
     * STEP 5: Hitung Jarak Euclidean ke Solusi Ideal
     *
     * D+_i = sqrt(Σ_j(y_ij - A+_j)²)
     * D-_i = sqrt(Σ_j(y_ij - A-_j)²)
     */
    private function hitungJarak(): void
    {
        foreach ($this->jurusanList as $idJurusan => $jurusan) {
            $sumPlus  = 0;
            $sumMinus = 0;

            foreach ($this->kriteriaList as $idKriteria => $kriteria) {
                $yij      = $this->matriksY[$idJurusan][$idKriteria] ?? 0;
                $sumPlus  += pow($yij - ($this->idealPositif[$idKriteria] ?? 0), 2);
                $sumMinus += pow($yij - ($this->idealNegatif[$idKriteria] ?? 0), 2);
            }

            $this->jarakPlus[$idJurusan]  = round(sqrt($sumPlus),  6);
            $this->jarakMinus[$idJurusan] = round(sqrt($sumMinus), 6);
        }
    }

    /**
     * STEP 6 & 7: Hitung Nilai Preferensi dan Ranking
     *
     * V_i = D-_i / (D+_i + D-_i)
     *
     * V_i mendekati 1 → lebih dekat ke solusi ideal positif → lebih direkomendasikan.
     */
    private function hitungPreferensiDanRanking(): array
    {
        foreach ($this->jurusanList as $idJurusan => $jurusan) {
            $dPlus  = $this->jarakPlus[$idJurusan]  ?? 0;
            $dMinus = $this->jarakMinus[$idJurusan] ?? 0;
            $total  = $dPlus + $dMinus;

            $this->nilaiPreferensi[$idJurusan] = $total > 0
                ? round($dMinus / $total, 6)
                : 0;
        }

        arsort($this->nilaiPreferensi);

        $ranking   = [];
        $peringkat = 1;
        foreach ($this->nilaiPreferensi as $idJurusan => $vi) {
            $jurusan   = $this->jurusanList[$idJurusan];
            $ranking[] = [
                'peringkat'    => $peringkat,
                'id_jurusan'   => $idJurusan,
                'nama_jurusan' => $jurusan['nama_jurusan'],
                'jenjang'      => $jurusan['jenjang'],
                'fakultas'     => $jurusan['fakultas'],
                'vi'           => $vi,
                'vi_persen'    => round($vi * 100, 2),
                'd_plus'       => $this->jarakPlus[$idJurusan]  ?? 0,
                'd_minus'      => $this->jarakMinus[$idJurusan] ?? 0,
            ];
            $peringkat++;
        }

        return $ranking;
    }
}