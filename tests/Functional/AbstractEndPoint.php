<?php

namespace App\Tests\Functional;

use App\DataFixtures\UserFixtures;
use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractEndPoint extends WebTestCase
{
    /**
     * @var array<string, string>
     */
    protected array $serverInformations = [
        'ACCEPT' => 'application/json',
        'CONTENT_TYPE' => 'application/json',
    ];
    protected string $tokenNotFound = 'JWT token not found';
    protected string $notYourResource = 'It\'s not your resource';
    protected string $loginPayload = '{"username":"%s","password":"%s"}';
    protected bool $withAuthentification = true;

    /**
     * @throws JsonException
     */
    public function getResponseFromRequest(
        string $method,
        string $uri,
        string $payload = '',
        array $parameters = []
    ): Response {
        $client = $this->createAuthentificationClient();
        $client->request(
            $method,
            $uri.'.json',
            $parameters,
            [],
            $this->serverInformations,
            $payload
        );

        return $client->getResponse();
    }

    /**
     * @throws JsonException
     */
    protected function createAuthentificationClient(): KernelBrowser
    {
        $client = static::createClient();
        if (!$this->withAuthentification) {
            return $client;
        }
        $client->request(
            Request::METHOD_POST,
            '/api/login_check',
            [],
            [],
            $this->serverInformations,
            sprintf($this->loginPayload, UserFixtures::DEFAULT_USER['email'], UserFixtures::DEFAULT_USER['password'])
        );
        $data = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }
}
