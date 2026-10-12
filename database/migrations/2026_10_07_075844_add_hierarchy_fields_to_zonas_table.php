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
        Schema::table('zonas', function (Blueprint $table) {
            $table->string('tingkat', 20)->default('kabupaten')->after('nama_wilayah')->index();
            $table->string('kode_wilayah', 30)->nullable()->after('tingkat')->index();
            $table->string('parent_kode', 30)->nullable()->after('kode_wilayah')->index();
            $table->string('parent_nama', 255)->nullable()->after('parent_kode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zonas', function (Blueprint $table) {
            $table->dropColumn(['tingkat', 'kode_wilayah', 'parent_kode', 'parent_nama']);
        });
    }
};
