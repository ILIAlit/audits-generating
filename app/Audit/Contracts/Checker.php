<?php

namespace App\Audit\Contracts;

use App\Audit\DTO\AuditResult;

interface Checker
{
    public function check(string $url, AuditResult $result): void;
}