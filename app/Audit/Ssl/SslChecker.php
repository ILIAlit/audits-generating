<?php

namespace App\Audit\Ssl;

use App\Audit\Contracts\Checker;
use App\Audit\DTO\AuditResult;
use App\Audit\Ssl\Services\SslClient;
use App\Audit\Ssl\Services\SslParser;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class SslChecker implements Checker
{
    public function __construct(private readonly SslClient $client, private readonly SslParser $parser) {}

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function check(string $url, AuditResult $result): void
    {
        $raw = $this->client->analize($url);
        $sslParseResult = $this->parser->parse($raw);
        $result->sslResult = $sslParseResult;
    }
}
