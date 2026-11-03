<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_jurusan', function (Blueprint $table) {
            $table->id('id_penilaian');
            $table->foreignId('id_jurusan')->constrained('jurusan', 'id_jurusan')->onDelete('cascade');
            $table->foreignId('id_kriteria')->constrained('kriteria', 'id_kriteria')->onDelete('cascade');
            $table->decimal('nilai', 8, 2)->comment('Nilai standar jurusan terhadap kriteria (skala 1-5)');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['id_jurusan', 'id_kriteria'], 'uq_penilaian_jurusan_kriteria');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_jurusan');
    }
};
