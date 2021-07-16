<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Record;
use App\Entity\User;
use App\Services\ResourceUpdaterInterface;
use DateTimeImmutable;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResourceUpdaterSubscriber implements EventSubscriberInterface
{
    private ResourceUpdaterInterface $resourceUpdater;

    public function __construct(ResourceUpdaterInterface $resourceUpdater)
    {
        $this->resourceUpdater = $resourceUpdater;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['check', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function check(ViewEvent $event): void
    {
        $object = $event->getControllerResult();
        if ($object instanceof User || $object instanceof Record) {
            $user = $object instanceof User ? $object : $object->getUser();
            $canProcess = $this->resourceUpdater->process($event->getRequest()->getMethod(), $user);
            if ($canProcess) {
                $user->setUpdatedAt(new DateTimeImmutable());
            }
        }
    }
}
