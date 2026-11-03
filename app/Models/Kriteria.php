<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';

    protected $fillable = [
        'nama_kriteria',
        'kode_kriteria',
        'bobot',
        'tipe',
        'deskripsi',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'bobot'     => 'float',
        'is_active' => 'boolean',
    ];

    public function kuesioner()
    {
        return $this->hasMany(Kuesioner::class, 'id_kriteria', 'id_kriteria');
    }

    public function penilaian()
    {
        return $this->hasMany(PenilaianJurusan::class, 'id_kriteria', 'id_kriteria');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }

    /**
     * Hitung bobot ternormalisasi (Wi) = bobot_i / sum(semua bobot)
     */
    public static function getBobotNormalized(): array
    {
        $kriteria = self::active()->get();
        $totalBobot = $kriteria->sum('bobot');

        $result = [];
        foreach ($kriteria as $k) {
            $result[$k->id_kriteria] = $totalBobot > 0 ? $k->bobot / $totalBobot : 0;
        }
        return $result;
    }
}
