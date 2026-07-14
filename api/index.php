<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Регистрируем автозагрузчик Composer
require __DIR__ . '/../vendor/autoload.php';

// Перенаправляем ВСЕ кэш-файлы Laravel во временную папку /tmp, доступную на запись
$cachePath = '/tmp/bootstrap-cache';
if (!is_dir($cachePath)) {
    mkdir($cachePath, 0755, true);
}

putenv("APP_packages_CACHE={$cachePath}/packages.php");
putenv("APP_services_CACHE={$cachePath}/services.php");
putenv("APP_config_CACHE={$cachePath}/config.php");
putenv("APP_routes_CACHE={$cachePath}/routes.php");

if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}
putenv('VIEW_COMPILED_PATH=/tmp/views');

// Запускаем приложение
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Обрабатываем входящий запрос
$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
