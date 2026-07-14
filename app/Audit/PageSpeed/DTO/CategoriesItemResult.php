<?php

namespace App\Audit\PageSpeed\DTO;

class CategoriesItemResult
{
    public string $id;

    public ?float $score;

    public ?string $title;

    public static function fromArray(string $id, array $category): self
    {
        $dto = new self;
        $dto->id = $id;
        $dto->title = $category['title'];
        $dto->score = $category['score'];

        return $dto;
    }
}
