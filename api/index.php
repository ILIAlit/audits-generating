<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    if (!is_dir('/tmp/views')) {
        mkdir('/tmp/views', 0755, true);
    }
    putenv('VIEW_COMPILED_PATH=/tmp/views');

    // Перехватываем внутренние ошибки Laravel до того, как включится класс view
    $app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class,
        new class($app) extends Illuminate\Foundation\Exceptions\Handler {
            public function render($request, Throwable $e) {
                header('Content-Type: text/plain', true, 500);
                echo "ACTUAL UNDERLYING LARAVEL ERROR:\n";
                echo $e->getMessage() . "\n\n";
                echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n\n";
                echo "Code: " . $e->getCode() . "\n\n";
                echo "Trace:\n" . $e->getTraceAsString();
                exit(1);
            }
        }
    );

    $kernel = $app->make(Kernel::class);

    $response = $kernel->handle(
        $request = Request::capture()
    );

    $response->send();
    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    header('Content-Type: text/plain', true, 500);
    echo "BOOTSTRAP ERROR:\n" . $e->getMessage();
    exit(1);
}
