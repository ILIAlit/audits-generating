<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // ВАЖНО: Перехватываем ВСЕ ошибки на Vercel и выводим их чистым текстом
        $exceptions->renderable(function (Throwable $e) {
            if (env('LOG_CHANNEL') === 'stderr' || true) {
                header('Content-Type: text/plain', true, 500);
                echo "ACTUAL UNDERLYING ERROR:\n";
                echo $e->getMessage()."\n\n";
                echo 'File: '.$e->getFile().' on line '.$e->getLine()."\n\n";
                echo "Trace:\n".$e->getTraceAsString();
                exit(1);
            }
        });
    })->create();
