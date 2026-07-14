<?php

use App\Audit\AuditManager;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::get('/test', function () {
    $manager = app(AuditManager::class);
    dd($manager->run('https://www.kolosbel.by/'));
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth/google.php';
