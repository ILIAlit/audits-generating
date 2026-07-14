<?php

namespace App\Audit\DTO;

use App\Audit\PageSpeed\DTO\PageSpeedResult;
use App\Audit\Ssl\DTO\SslResult;

class AuditResult
{
    public ?PageSpeedResult $pageSpeed = null;

    public ?SslResult $sslResult = null;
}
