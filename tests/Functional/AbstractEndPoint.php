<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractEndPoint extends WebTestCase
{
    /**
     * @var array<string, string>
     */
    private array $serverInformations = [
        'ACCEPT' => 'application/json',
        'CONTENT_TYPE' => 'application/json',
    ];

    public function getResponseFromRequest(string $method, string $uri, string $payload = ''): Response
    {
        $client = self::createClient();
        $client->request(
            $method,
            $uri . '.json',
            [],
            [],
            $this->serverInformations,
            $payload
        );
        return $client->getResponse();
    }
}
