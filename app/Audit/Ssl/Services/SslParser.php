<?php

namespace App\Audit\Ssl\Services;

use App\Audit\Ssl\DTO\CertificatesItemResult;
use App\Audit\Ssl\DTO\SslResult;

class SslParser
{
    public function parse($responseData): SslResult
    {
        $sslResult = new SslResult;
        $sslResult->certificates = $this->parseCertificates($responseData);

        return $sslResult;
    }

    public function parseCertificates($responseData): array
    {
        $certificate = $responseData['certificate'];
        $certificateResults = [];
        $serialNumber = $certificate['serial_number'];
        $certificateResults[] = CertificatesItemResult::fromArray($serialNumber, $certificate);

        return $certificateResults;
    }
}
