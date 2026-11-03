<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';

    protected $fillable = [
        'nama_jurusan',
        'jenjang',
        'fakultas',
        'singkatan',
        'deskripsi',
        'akreditasi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function penilaian()
    {
        return $this->hasMany(PenilaianJurusan::class, 'id_jurusan', 'id_jurusan');
    }

    public function penilaianByKriteria($id_kriteria)
    {
        return $this->penilaian()->where('id_kriteria', $id_kriteria)->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeS1($query)
    {
        return $query->where('jenjang', 'S1');
    }

    public function scopeD3($query)
    {
        return $query->where('jenjang', 'D3');
    }
}
