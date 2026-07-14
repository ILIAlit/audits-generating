<?php

namespace App\Audit;

use App\Audit\Contracts\Checker;
use App\Audit\DTO\AuditResult;

class AuditManager
{
    protected array $checkers = [];

    public function __construct()
    {
        foreach (config('audit.checkers') as $checker) {

            $this->addChecker(
                app($checker)
            );

        }
    }

    public function addChecker(Checker $checker): self
    {
        $this->checkers[] = $checker;

        $a = 'test';

        return $this;
    }

    public function run(string $url): AuditResult
    {
        $result = new AuditResult;

        foreach ($this->checkers as $checker) {
            $checker->check($url, $result);
        }

        return $result;
    }
}
