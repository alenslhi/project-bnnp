<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statistik_kasuses', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dataset'); // untuk metode versi dataset (misal "Data Pengguna 2024")
            $table->integer('tahun');
            $table->string('kelompok_umur')->nullable(); // misal: "15-24 Tahun"
            $table->string('jenis_kelamin')->nullable(); // L / P
            $table->string('jenis_narkotika')->nullable(); // Sabu, Ganja, dll
            $table->string('pekerjaan')->nullable(); // Pelajar, Wiraswasta, dll
            $table->integer('jumlah_kasus')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistik_kasuses');
    }
};
