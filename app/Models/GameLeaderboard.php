<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameLeaderboard extends Model
{
    use HasFactory;

    protected $table = 'game_leaderboards';

    protected $fillable = [
        'period_date',
        'player_name',
        'player_organization',
        'total_score',
        'quiz_score',
        'quiz_correct_count',
        'word1_score',
        'word1_attempts',
        'word2_score',
        'word2_attempts',
        'speed_bonus',
        'retry_penalty',
        'retry_count',
        'duration_seconds',
        'device_fingerprint',
        'ip_address',
    ];

    protected $casts = [
        'period_date' => 'date',
        'total_score' => 'integer',
        'quiz_score' => 'integer',
        'quiz_correct_count' => 'integer',
        'word1_score' => 'integer',
        'word1_attempts' => 'integer',
        'word2_score' => 'integer',
        'word2_attempts' => 'integer',
        'speed_bonus' => 'integer',
        'retry_penalty' => 'integer',
        'retry_count' => 'integer',
        'duration_seconds' => 'integer',
    ];

    /**
     * Mendapatkan tanggal periode aktif leaderboard berdasarkan siklus jam 07:00 WITA.
     * Jika sebelum jam 07:00 WITA, masuk periode hari sebelumnya.
     * Setelah jam 07:00 WITA, masuk periode hari berjalan.
     */
    public static function getCurrentPeriodDate(): string
    {
        $nowWita = Carbon::now('Asia/Makassar');
        if ($nowWita->hour < 7) {
            return $nowWita->copy()->subDay()->toDateString();
        }
        return $nowWita->toDateString();
    }

    /**
     * Waktu Carbon persis kapan leaderboard periode ini akan di-reset (Jam 07:00 WITA berikutnya).
     */
    public static function getNextResetCarbon(): Carbon
    {
        $nowWita = Carbon::now('Asia/Makassar');
        if ($nowWita->hour < 7) {
            return $nowWita->copy()->setHour(7)->setMinute(0)->setSecond(0);
        }
        return $nowWita->copy()->addDay()->setHour(7)->setMinute(0)->setSecond(0);
    }

    /**
     * Algoritma perhitungan skor komprehensif & terstandarisasi.
     */
    public static function computeScore(array $input): array
    {
        $quizCorrect = max(0, min(5, (int) ($input['quiz_correct_count'] ?? 0)));
        $quizScore = $quizCorrect * 60; // Max 300

        $word1Won = (bool) ($input['word1_won'] ?? false);
        $w1Attempts = max(1, min(6, (int) ($input['word1_attempts'] ?? 6)));
        $word1Score = 0;
        if ($word1Won) {
            $base = 250;
            $attemptBonus = match ($w1Attempts) {
                1 => 100,
                2 => 80,
                3 => 60,
                4 => 40,
                5 => 20,
                default => 0,
            };
            $word1Score = $base + $attemptBonus; // Max 350
        }

        $word2Won = (bool) ($input['word2_won'] ?? false);
        $w2Attempts = max(1, min(6, (int) ($input['word2_attempts'] ?? 6)));
        $word2Score = 0;
        if ($word2Won) {
            $base = 250;
            $attemptBonus = match ($w2Attempts) {
                1 => 100,
                2 => 80,
                3 => 60,
                4 => 40,
                5 => 20,
                default => 0,
            };
            $word2Score = $base + $attemptBonus; // Max 350
        }

        $duration = max(5, (int) ($input['duration_seconds'] ?? 0));
        $speedBonus = match (true) {
            $duration <= 60 => 100,
            $duration <= 120 => 80,
            $duration <= 180 => 60,
            $duration <= 300 => 40,
            default => 15,
        };

        $retryCount = max(0, (int) ($input['retry_count'] ?? 0));
        $retryPenalty = min(150, $retryCount * 50);

        $totalScore = max(0, $quizScore + $word1Score + $word2Score + $speedBonus - $retryPenalty);

        $badgeTitle = match (true) {
            $totalScore >= 1000 => 'Master P4GN Paripurna',
            $totalScore >= 850 => 'Pejuang Bersinar Tangguh',
            $totalScore >= 700 => 'Relawan Sadar Narkoba',
            $totalScore >= 500 => 'Penggiat Muda P4GN',
            default => 'Sahabat Sadar P4GN',
        };

        return [
            'total_score' => $totalScore,
            'quiz_score' => $quizScore,
            'quiz_correct_count' => $quizCorrect,
            'word1_score' => $word1Score,
            'word1_attempts' => $w1Attempts,
            'word2_score' => $word2Score,
            'word2_attempts' => $w2Attempts,
            'speed_bonus' => $speedBonus,
            'retry_penalty' => $retryPenalty,
            'retry_count' => $retryCount,
            'duration_seconds' => $duration,
            'badge_title' => $badgeTitle,
        ];
    }
}
