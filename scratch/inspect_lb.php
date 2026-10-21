<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$records = App\Models\GameLeaderboard::latest()->take(10)->get();
foreach ($records as $r) {
    echo "ID: {$r->id} | Name: {$r->player_name} | Score: {$r->total_score} | Quiz: {$r->quiz_score} | W1: {$r->word1_score} | W2: {$r->word2_score} | Speed: {$r->speed_bonus} | Date: {$r->period_date} | FP: {$r->device_fingerprint}\n";
}
