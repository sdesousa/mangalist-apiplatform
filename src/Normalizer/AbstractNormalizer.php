<?php

namespace App\Normalizer;

use Exception;

abstract class AbstractNormalizer implements NormalizerInterface
{
    private array $exceptionTypes;

    public function __construct(array $exceptionTypes)
    {
        $this->exceptionTypes = $exceptionTypes;
    }

    public function supports(Exception $exception): bool
    {
        return in_array(get_class($exception), $this->exceptionTypes, true);
    }
}
