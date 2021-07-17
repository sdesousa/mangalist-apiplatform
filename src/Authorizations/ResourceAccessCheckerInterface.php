<?php

namespace App\Authorizations;

interface ResourceAccessCheckerInterface
{
    public const MESSAGE_ERROR = 'It\'s not your resource';

    public function canAccess(?int $id): void;
}
