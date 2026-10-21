<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $request = \Illuminate\Http\Request::create('/game', 'GET');
    $controller = new App\Http\Controllers\GameController();
    $view = $controller->index($request);
    $html = $view->render();
    echo "Blade render SUCCESS! Rendered " . strlen($html) . " bytes\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}
