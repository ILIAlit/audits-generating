<?php

namespace App\Audit\PageSpeed\DTO;

class AuditItemResult
{
    public string $id;

    public ?float $score;

    public string $title;

    public ?string $description;

    public static function fromArray(string $id, array $audit): self
    {
        $dto = new self;

        $dto->id = $id;
        $dto->score = $audit['score'] ?? null;
        $dto->title = $audit['title'] ?? null;
        $dto->description = $audit['description'] ?? null;

        return $dto;

    }
}
