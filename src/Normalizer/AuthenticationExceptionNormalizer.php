<?php

namespace App\Normalizer;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationExceptionNormalizer extends AbstractNormalizer
{
    public function normalize(Exception $exception): array
    {
        $result = [];
        $result['code'] = Response::HTTP_UNAUTHORIZED;
        $result['body'] = [
            'code' => $result['code'],
            'message' => $exception->getMessage(),
        ];

        return $result;
    }
}
