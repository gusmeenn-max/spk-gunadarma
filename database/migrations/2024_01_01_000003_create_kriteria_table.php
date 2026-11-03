<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id('id_kriteria');
            $table->string('nama_kriteria');
            $table->string('kode_kriteria')->unique()->nullable()->comment('Contoh: C1, C2, dst');
            $table->decimal('bobot', 5, 2)->comment('Bobot kepentingan 1-5');
            $table->enum('tipe', ['benefit', 'cost'])->comment('benefit=semakin tinggi semakin baik, cost=semakin rendah semakin baik');
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriteria');
    }
};
