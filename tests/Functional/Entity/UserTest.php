<?php

namespace App\Tests\Functional\Entity;

use App\DataFixtures\UserFixtures;
use App\Tests\Functional\AbstractEndPoint;
use Faker\Factory;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends AbstractEndPoint
{
    private string $userPayload = '{"email": "%s", "password": "password"}';

    /**
     * @throws JsonException
     */
    public function testGetUsers(): void
    {
        $this->withAuthentification = false;
        $response = $this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/users',
            '',
            [],
        );
        $responseContent = $response->getContent();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        if ($responseContent) {
            $responseDecoded = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
            self::assertJson($responseContent);
            self::assertNotEmpty($responseDecoded);
        }
    }

    public function testGetDefaultUser(): int
    {
        $this->withAuthentification = false;
        $response = $this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/users',
            '',
            ['email' => UserFixtures::DEFAULT_USER['email']],
        );
        $responseContent = $response->getContent();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        if ($responseContent) {
            $responseDecoded = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
            self::assertJson($responseContent);
            self::assertNotEmpty($responseDecoded);
        }

        return $responseDecoded[0]['id'];
    }

    /**
     * @throws JsonException
     */
    public function testPostUsers(): void
    {
        $this->withAuthentification = false;
        $response = $this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/users',
            $this->getPayload(),
            [],
        );
        $responseContent = $response->getContent();
        self::assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        if ($responseContent) {
            $responseDecoded = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
            self::assertJson($responseContent);
            self::assertNotEmpty($responseDecoded);
        }
    }

    /**
     * @throws JsonException
     * @depends testGetDefaultUser
     */
    public function testPutDefaultUser(int $id): void
    {
        $this->withAuthentification = false;
        $response = $this->getResponseFromRequest(
            Request::METHOD_PUT,
            '/api/users/'.$id,
            $this->getPayload(),
            [],
        );
        $responseContent = $response->getContent();
        self::assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        if ($responseContent) {
            $responseDecoded = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
            self::assertJson($responseContent);
            self::assertNotEmpty($responseDecoded);
        }
    }

    /**
     * @throws JsonException
     * @depends testGetDefaultUser
     */
    public function testPatchDefaultUsers(int $id): void
    {
        $this->withAuthentification = false;
        $response = $this->getResponseFromRequest(
            Request::METHOD_PATCH,
            '/api/users/'.$id,
            $this->getPayload(),
            [],
        );
        $responseContent = $response->getContent();
        self::assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        if ($responseContent) {
            $responseDecoded = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
            self::assertJson($responseContent);
            self::assertNotEmpty($responseDecoded);
        }
    }

    /**
     * @throws JsonException
     * @depends testGetDefaultUser
     */
    public function testDeleteDefaultUser(int $id): void
    {
        $this->withAuthentification = false;
        $response = $this->getResponseFromRequest(
            Request::METHOD_DELETE,
            '/api/users/'.$id,
            '',
            [],
        );
        $responseContent = $response->getContent();

        self::assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        if ($responseContent) {
            $responseDecoded = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
            self::assertJson($responseContent);
            self::assertNotEmpty($responseDecoded);
        }
    }

    private function getPayload(): string
    {
        $faker = Factory::create();

        return sprintf($this->userPayload, $faker->email());
    }
}
