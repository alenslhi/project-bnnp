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
        Schema::create('game_leaderboards', function (Blueprint $table) {
            $table->id();
            $table->date('period_date')->index(); // Tanggal periode harian (reset tiap jam 07:00 WITA)
            $table->string('player_name', 50);
            $table->string('player_organization', 80)->nullable();
            $table->unsignedInteger('total_score')->default(0)->index();
            $table->unsignedSmallInteger('quiz_score')->default(0);
            $table->unsignedTinyInteger('quiz_correct_count')->default(0);
            $table->unsignedSmallInteger('word1_score')->default(0);
            $table->unsignedTinyInteger('word1_attempts')->default(0);
            $table->unsignedSmallInteger('word2_score')->default(0);
            $table->unsignedTinyInteger('word2_attempts')->default(0);
            $table->unsignedSmallInteger('speed_bonus')->default(0);
            $table->unsignedSmallInteger('retry_penalty')->default(0);
            $table->unsignedTinyInteger('retry_count')->default(0);
            $table->unsignedInteger('duration_seconds')->default(0);
            $table->string('device_fingerprint', 100)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            // Index komposit untuk query leaderboard cepat per periode
            $table->index(['period_date', 'total_score', 'duration_seconds'], 'idx_leaderboard_rank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_leaderboards');
    }
};
