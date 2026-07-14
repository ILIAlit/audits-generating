<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Подключаем автозагрузчик
require __DIR__ . '/../vendor/autoload.php';

try {
    // Инициализируем приложение
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // Настраиваем пути для кэша шаблонов в /tmp
    if (!is_dir('/tmp/views')) {
        mkdir('/tmp/views', 0755, true);
    }
    putenv('VIEW_COMPILED_PATH=/tmp/views');

    // Обрабатываем запрос
    $kernel = $app->make(Kernel::class);

    $response = $kernel->handle(
        $request = Request::capture()
    );

    $response->send();

    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    // ВАЖНО: Если Laravel упал на старте, выводим реальную ошибку в логи Vercel
    header('Content-Type: text/plain', true, 500);
    echo "CRITICAL LARAVEL ERROR:\n";
    echo $e->getMessage() . "\n\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n\n";
    echo "Stack Trace:\n" . $e->getTraceAsString();
    exit(1);
}
