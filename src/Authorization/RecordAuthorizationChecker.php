<?php

namespace App\Authorization;

use App\Entity\Record;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class RecordAuthorizationChecker
{
    private array $methodAllowed = [
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
        Request::METHOD_DELETE,
    ];
    private ?UserInterface $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
//        dd($this->user);
    }

    public function check(Record $record, string $method): void
    {
        $this->isAuthenticated();
        if ($this->isMethodAllowed($method) && $record->getUser()->getId() !== $this->user->getId()) {
            $errorMessage = "It's not your resource";

            throw new UnauthorizedHttpException($errorMessage, $errorMessage);
        }
    }

    public function isAuthenticated(): void
    {
        if (null === $this->user) {
            $error = 'You are not authenticated';

            throw new UnauthorizedHttpException($error, $error);
        }
    }

    public function isMethodAllowed(string $method): bool
    {
        return in_array($method, $this->methodAllowed, true);
    }
}
