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
        // Tabel Bank Soal Mitos & Fakta Narkotika
        Schema::create('game_mitos_faktas', function (Blueprint $table) {
            $table->id();
            $table->text('statement'); // Pernyataan mitos atau fakta
            $table->boolean('is_fakta')->default(false); // true = Fakta, false = Mitos
            $table->string('badge', 100)->nullable(); // Kategori topik (e.g. Adiksi & Otak, Hukum, dll)
            $table->text('explanation'); // Penjelasan ilmiah & edukasi detail
            $table->text('clue')->nullable(); // Petunjuk kata kunci untuk Wordle / intisari
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_fakta');
            $table->index('badge');
            $table->index('is_active');
        });

        // Tabel Bank Kata Wordle Narkotika (Panjang dinamis 3-15 Huruf)
        Schema::create('game_wordles', function (Blueprint $table) {
            $table->id();
            $table->string('word', 30)->unique(); // Kata target kapital (3-15 huruf)
            $table->unsignedTinyInteger('length')->default(5); // Panjang huruf
            $table->text('hint'); // Petunjuk tebakan
            $table->text('definition'); // Penjelasan lengkap kata & edukasi narkotika
            $table->string('category', 100)->nullable(); // Kategori kata
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('word');
            $table->index('category');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_wordles');
        Schema::dropIfExists('game_mitos_faktas');
    }
};
