<?php

namespace App\Audit\Ssl\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class SslClient
{
    private string $apiKey = 'at_2qpm3coqMFBD0WJWR84cEXbASLa0y';

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function analize(string $url): array
    {
        $response = Http::timeout(120)
            ->retry(3, 500)
            ->get('https://ssl-certificates.whoisxmlapi.com/api/v1?', [
                'apiKey' => $this->apiKey,
                'domainName' => $url,
            ]);
        $response->throw();

        return $response->json();
    }
}
