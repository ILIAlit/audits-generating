<?php

// Регистрируем автозагрузчик Composer
require __DIR__ . '/../vendor/autoload.php';

// Запускаем приложение Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Перенаправляем скомпилированные views в /tmp
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}
putenv('VIEW_COMPILED_PATH=/tmp/views');

// Обрабатываем входящий запрос
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
