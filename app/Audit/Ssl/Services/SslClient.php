<?php

namespace App\Audit\Ssl\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class SslClient
{
    private string $apiKey = 'dsk_5105114246b2160057ff962212fe989537f1bb1fd75d3c437143908621547e59';

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function analize(string $url): array
    {
        $response = Http::timeout(120)
            ->retry(3, 500)
            ->withHeader('x-api-key', $this->apiKey)
            ->get('https://domscan.net/v1/ssl/audit?', [
                'domain' => parse_url($url, PHP_URL_HOST),
            ]);
        $response->throw();

        return $response->json();
    }
}
