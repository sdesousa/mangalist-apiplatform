<?php

namespace App\Normalizer;

use Exception;

interface NormalizerInterface
{
    public function normalize(Exception $exception): array;

    public function supports(Exception $exception): bool;
}
