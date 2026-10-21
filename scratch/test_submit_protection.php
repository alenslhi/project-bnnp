<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$testFp = 'test_fp_verify_protection_' . time();
$controller = new App\Http\Controllers\GameController();

// 1. Submit initial high score (1100)
$payload1 = [
    'player_name' => 'Richard Juara',
    'player_organization' => null,
    'quiz_correct_count' => 5,
    'word1_attempts' => 1,
    'word2_attempts' => 1,
    'word1_won' => true,
    'word2_won' => true,
    'duration_seconds' => 45,
    'retry_count' => 0,
    'device_fingerprint' => $testFp,
];

$req1 = \Illuminate\Http\Request::create('/game/leaderboard/submit', 'POST', $payload1);
$res1 = $controller->submitScore($req1);
$data1 = json_decode($res1->getContent(), true);

echo "Step 1: Submitted high score -> Status: {$data1['success']}, Score: {$data1['total_score']}, Name: {$data1['player_name']}\n";

// 2. Simulate refresh bug: sending 400 pts (word1_won=false, word2_won=false) from same device
$payload2 = [
    'player_name' => 'Richard Ganti Nama',
    'player_organization' => null,
    'quiz_correct_count' => 5,
    'word1_attempts' => 6,
    'word2_attempts' => 6,
    'word1_won' => false,
    'word2_won' => false,
    'duration_seconds' => 45,
    'retry_count' => 0,
    'device_fingerprint' => $testFp,
];

$req2 = \Illuminate\Http\Request::create('/game/leaderboard/submit', 'POST', $payload2);
$res2 = $controller->submitScore($req2);
$data2 = json_decode($res2->getContent(), true);

echo "Step 2: Resubmitted lower score (400) -> Status: {$data2['success']}, Score: {$data2['total_score']}, Name: {$data2['player_name']}\n";

// Check in DB
$row = App\Models\GameLeaderboard::where('device_fingerprint', $testFp)->first();
echo "DB Check: Score is {$row->total_score} (Expected: 1100), Name is '{$row->player_name}'\n";

// Clean up test row
$row->delete();
echo "Cleanup: Test row deleted.\n";
