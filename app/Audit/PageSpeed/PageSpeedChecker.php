<?php

namespace App\Audit\PageSpeed;

use App\Audit\Contracts\Checker;
use App\Audit\DTO\AuditResult;
use App\Audit\PageSpeed\Services\PageSpeedClient;
use App\Audit\PageSpeed\Services\PageSpeedParser;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class PageSpeedChecker implements Checker
{
    public function __construct(private readonly PageSpeedClient $client, private readonly PageSpeedParser $parser) {}

    private array $categories = [
        'performance',
        'seo',
        'best-practices',
        'accessibility',
    ];

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function check(string $url, AuditResult $result): void
    {
        $raw = $this->client->analyze($url, $this->categories);
        $parsedPageSpeed = $this->parser->parse($raw);
        $result->pageSpeed = $parsedPageSpeed;
    }
}
