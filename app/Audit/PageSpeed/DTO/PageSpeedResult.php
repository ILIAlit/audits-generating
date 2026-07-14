<?php

namespace App\Audit\PageSpeed\DTO;

class PageSpeedResult
{
    /** @var AuditItemResult[] */
    public array $audits = [];

    public array $loadingExperience = [];

    /** @var CategoriesItemResult[] */
    public array $categories = [];
}
