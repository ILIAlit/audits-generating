<?php

use App\Audit\PageSpeed\PageSpeedChecker;
use App\Audit\Ssl\SslChecker;

return [
    'checkers' => [
        PageSpeedChecker::class,
        SslChecker::class,
    ],
];
