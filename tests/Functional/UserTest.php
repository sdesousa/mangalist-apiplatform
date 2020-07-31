<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory;

class UserTest extends AbstractEndPoint
{
    private string $userPayload = '{"email": "%s", "password": "password"}';

    public function testGetUsers(): void
    {
        $response = $this->getResponseFromRequest(Request::METHOD_GET, '/api/users');
        $responseContent = $response->getContent();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        if ($responseContent) {
            $responseDecoded = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
            self::assertJson($responseContent);
            self::assertNotEmpty($responseDecoded);
        }
    }

    public function testPostUsers(): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/users',
            $this->getPayload()
        );
        $responseContent = $response->getContent();

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        if ($responseContent) {
            $responseDecoded = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
            self::assertJson($responseContent);
            self::assertNotEmpty($responseDecoded);
        }
    }

    private function getPayload(): string
    {
        $faker = Factory::create();
        return sprintf($this->userPayload, $faker->email);
    }
}
