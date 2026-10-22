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
        if (Schema::hasTable('edukasis')) {
            if (Schema::hasColumn('edukasis', 'gambar_cover') && !Schema::hasColumn('edukasis', 'gambar')) {
                Schema::table('edukasis', function (Blueprint $table) {
                    $table->renameColumn('gambar_cover', 'gambar');
                });
            } elseif (!Schema::hasColumn('edukasis', 'gambar')) {
                Schema::table('edukasis', function (Blueprint $table) {
                    $table->string('gambar')->nullable()->after('konten');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('edukasis')) {
            if (Schema::hasColumn('edukasis', 'gambar') && !Schema::hasColumn('edukasis', 'gambar_cover')) {
                Schema::table('edukasis', function (Blueprint $table) {
                    $table->renameColumn('gambar', 'gambar_cover');
                });
            }
        }
    }
};
