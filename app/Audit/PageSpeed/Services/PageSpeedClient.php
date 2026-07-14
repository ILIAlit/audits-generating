<?php

namespace App\Audit\PageSpeed\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class PageSpeedClient
{
    private string $apiKey = 'AIzaSyAgR-VJqeFUUPT3l12h0G9fo9mwo1Tw450';

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function analyze(string $url, array $categories): array
    {
        $response = Http::timeout(120)
            ->retry(3, 500)
            ->get($this->buildPageSpeedUrl($url, $categories));

        $response->throw();

        return $response->json();
    }

    private function buildPageSpeedUrl(string $url, array $categories): string
    {
        $query = http_build_query([
            'url' => $url,
            'key' => $this->apiKey,
            'locale' => 'ru',
        ]);

        foreach ($categories as $category) {
            $query .= '&category='.urlencode($category);
        }

        return "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?$query";
    }
}
