<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Регистрируем автозагрузчик Composer
require __DIR__ . '/../vendor/autoload.php';

// Инициализируем приложение Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// КРИТИЧЕСКИЙ ХАК ДЛЯ VERCEL:
// Переопределяем путь к bootstrap/cache во временную папку /tmp, которая открыта на запись
$app->useBootstrapPath('/tmp');

// Создаем структуру папок в /tmp, если её ещё нет
if (!is_dir('/tmp/cache')) {
    mkdir('/tmp/cache', 0755, true);
}
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

// Дополнительно прописываем системные пути для кэша через putenv
putenv('APP_packages_CACHE=/tmp/cache/packages.php');
putenv('APP_services_CACHE=/tmp/cache/services.php');
putenv('APP_config_CACHE=/tmp/cache/config.php');
putenv('APP_routes_CACHE=/tmp/cache/routes.php');
putenv('VIEW_COMPILED_PATH=/tmp/views');

// Обрабатываем входящий запрос через ядро
$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
