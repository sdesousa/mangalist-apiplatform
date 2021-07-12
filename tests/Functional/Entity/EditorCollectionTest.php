<?php

namespace App\Tests\Functional\Entity;

use App\Tests\Functional\AbstractEndPoint;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 * @coversNothing
 */
class EditorCollectionTest extends AbstractEndPoint
{
    /**
     * @throws JsonException
     */
    public function testGetEditorCollections(): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/editor_collections',
            '',
            [],
            false
        );
        $responseContent = $response->getContent();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        if ($responseContent) {
            $responseDecoded = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
            self::assertJson($responseContent);
            self::assertNotEmpty($responseDecoded);
        }
    }
}
