<?php

namespace App\Audit\PageSpeed\Services;

use App\Audit\PageSpeed\DTO\AuditItemResult;
use App\Audit\PageSpeed\DTO\CategoriesItemResult;
use App\Audit\PageSpeed\DTO\PageSpeedResult;

class PageSpeedParser
{
    public function parse(array $response): PageSpeedResult
    {
        $pageSpeedResult = new PageSpeedResult;
        $pageSpeedResult->categories = $this->parseScoreCategories($response);
        $pageSpeedResult->audits = $this->parseAudits($response);

        return $pageSpeedResult;
    }

    private function parseAudits(array $dataResponse): array
    {
        $lighthouse = $dataResponse['lighthouseResult'];
        $audits = $lighthouse['audits'];
        $auditsResult = [];

        foreach ($audits as $id => $audit) {
            if (isset($audit['score']) && $audit['score'] < 1 && ! empty($audit['title'])) {
                $auditsResult[] = AuditItemResult::fromArray($id, $audit);
            }
        }

        return $auditsResult;
    }

    private function parseScoreCategories(array $dataResponse): array
    {
        $lighthouse = $dataResponse['lighthouseResult'];
        $categories = $lighthouse['categories'];
        $categoriesResult = [];
        foreach ($categories as $id => $category) {
            $categoriesResult[] = CategoriesItemResult::fromArray($id, $category);
        }

        return $categoriesResult;
    }
}
