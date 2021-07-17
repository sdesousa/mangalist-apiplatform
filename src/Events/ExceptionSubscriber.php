<?php

namespace App\Events;

use App\Factory\JsonResponseInterface;
use App\Normalizer\NormalizerInterface;
use App\Services\ExceptionNormalizerFormatterInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private static array $normalizers;
    private SerializerInterface $serializer;
    private ExceptionNormalizerFormatterInterface $normalizerFormatter;
    private JsonResponseInterface $jsonResponse;

    public function __construct(
        SerializerInterface $serializer,
        ExceptionNormalizerFormatterInterface $normalizerFormatter,
        JsonResponseInterface $jsonResponse
    ) {
        $this->serializer = $serializer;
        $this->normalizerFormatter = $normalizerFormatter;
        $this->jsonResponse = $jsonResponse;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [['processException', 0]],
        ];
    }

    public function processException(ExceptionEvent $event): void
    {
        $result = null;
        $exception = $event->getThrowable();
        foreach (self::$normalizers as $normalizer) {
            if ($normalizer->supports($exception)) {
                $result = $normalizer->normalize($exception);

                break;
            }
        }
        if (null === $result) {
            $result = $this->normalizerFormatter->format($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        $body = $this->serializer->serialize($result, 'json');
        $event->setResponse($this->jsonResponse->getJsonResponse(
            $result['code'],
            $body
        ));
    }

    public function addNormalizer(NormalizerInterface $normalizer): void
    {
        self::$normalizers[] = $normalizer;
    }
}
