<?php

namespace App\Normalizer;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ResourceAccessExceptionNormalizer extends AbstractNormalizer
{
    public function normalize(Exception $exception): array
    {
        return $this->normalizerFormatter->format($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
    }
}
