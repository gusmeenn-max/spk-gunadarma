<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    protected $table = 'hasil';
    protected $primaryKey = 'id_hasil';

    protected $fillable = [
        'id_user',
        'tanggal_hitung',
        'input_kuesioner',
        'detail_hasil',
        'matriks_keputusan',
        'matriks_ternormalisasi',
        'matriks_terbobot',
        'solusi_ideal',
        'jurusan_rekomendasi_1',
        'jurusan_rekomendasi_2',
        'jurusan_rekomendasi_3',
    ];

    protected $casts = [
        'tanggal_hitung'       => 'datetime',
        'input_kuesioner'      => 'array',
        'detail_hasil'         => 'array',
        'matriks_keputusan'    => 'array',
        'matriks_ternormalisasi' => 'array',
        'matriks_terbobot'     => 'array',
        'solusi_ideal'         => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function jurusanRek1()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_rekomendasi_1', 'id_jurusan');
    }

    public function jurusanRek2()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_rekomendasi_2', 'id_jurusan');
    }

    public function jurusanRek3()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_rekomendasi_3', 'id_jurusan');
    }

    /**
     * Ambil persentase kecocokan dari detail_hasil (nilai Vi*100)
     */
    public function getPersentaseRek1(): float
    {
        $detail = $this->detail_hasil;
        return isset($detail[0]['vi']) ? round($detail[0]['vi'] * 100, 2) : 0;
    }
}
