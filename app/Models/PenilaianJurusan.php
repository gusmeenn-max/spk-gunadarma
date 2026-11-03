<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianJurusan extends Model
{
    protected $table = 'penilaian_jurusan';
    protected $primaryKey = 'id_penilaian';

    protected $fillable = [
        'id_jurusan',
        'id_kriteria',
        'nilai',
        'keterangan',
    ];

    protected $casts = [
        'nilai' => 'float',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }
}
