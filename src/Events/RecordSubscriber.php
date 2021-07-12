<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Authorization\RecordAuthorizationChecker;
use App\Entity\Record;
use DateTimeImmutable;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RecordSubscriber implements EventSubscriberInterface
{
    private array $methodNotAllowed = [
        Request::METHOD_POST,
        Request::METHOD_GET,
    ];
    private RecordAuthorizationChecker $recordAuthorizationChecker;

    public function __construct(RecordAuthorizationChecker $recordAuthorizationChecker)
    {
        $this->recordAuthorizationChecker = $recordAuthorizationChecker;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['check', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function check(ViewEvent $event): void
    {
        $record = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if ($record instanceof Record && !in_array($method, $this->methodNotAllowed, true)) {
            $this->recordAuthorizationChecker->check($record, $method);
            $record->setUpdatedAt(new DateTimeImmutable());
        }
    }
}
