<?php

namespace App\Events;

use App\Normalizer\NormalizerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionListener implements EventSubscriberInterface
{
    private static array $normalizers;
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
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
            $result['code'] = Response::HTTP_BAD_REQUEST;
            $result['body'] = [
                'code' => $result['code'],
                'message' => $exception->getMessage(),
            ];
        }
        $body = $this->serializer->serialize($result['body'], 'json');
        $response = new Response($body, $result['code']);
        $response->headers->set('Content-Type', 'application/json');
        $event->setResponse($response);
    }

    public function addNormalizer(NormalizerInterface $normalizer): void
    {
        self::$normalizers[] = $normalizer;
    }
}
