<?php

namespace App\Authorizations;

interface AuthenticationCheckerInterface
{
    public const MESSAGE_ERROR = 'You are not authenticated';

    public function isAuthenticated(): void;
}
