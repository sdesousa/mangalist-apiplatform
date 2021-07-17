<?php

namespace App\Normalizer;

use App\Services\ExceptionNormalizerFormatterInterface;
use Exception;

abstract class AbstractNormalizer implements NormalizerInterface
{
    protected ExceptionNormalizerFormatterInterface $normalizerFormatter;
    private array $exceptionTypes;

    public function __construct(array $exceptionTypes, ExceptionNormalizerFormatterInterface $normalizerFormatter)
    {
        $this->exceptionTypes = $exceptionTypes;
        $this->normalizerFormatter = $normalizerFormatter;
    }

    public function supports(Exception $exception): bool
    {
        return in_array(get_class($exception), $this->exceptionTypes, true);
    }
}
