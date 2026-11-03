<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->timestamp('tanggal_hitung')->useCurrent();
            $table->json('input_kuesioner')->comment('Jawaban user dalam format JSON');
            $table->json('detail_hasil')->comment('Ranking lengkap beserta nilai Vi, D+, D-');
            $table->json('matriks_keputusan')->nullable()->comment('Matriks keputusan yang digunakan');
            $table->json('matriks_ternormalisasi')->nullable();
            $table->json('matriks_terbobot')->nullable();
            $table->json('solusi_ideal')->nullable()->comment('A+ dan A-');
            $table->integer('jurusan_rekomendasi_1')->nullable();
            $table->integer('jurusan_rekomendasi_2')->nullable();
            $table->integer('jurusan_rekomendasi_3')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil');
    }
};
