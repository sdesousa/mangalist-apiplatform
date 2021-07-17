<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;

class ExceptionNormalizerFormatter implements ExceptionNormalizerFormatterInterface
{
    public function format(string $message, int $statuscode = Response::HTTP_BAD_REQUEST): array
    {
        return [
            'code' => $statuscode,
            'message' => $message,
        ];
    }
}
