<?php

namespace App\Audit\Ssl\DTO;

use Carbon\CarbonImmutable;

class CertificatesItemResult
{
    public CarbonImmutable $validFrom;

    public CarbonImmutable $validTo;

    public string $number;

    public static function fromArray(string $serialNumber, array $certificate): self
    {
        $dto = new self;
        $dto->number = $serialNumber;
        $dto->validFrom = CarbonImmutable::parse($certificate['validFrom']);
        $dto->validTo = CarbonImmutable::parse($certificate['validTo']);

        return $dto;
    }
}
