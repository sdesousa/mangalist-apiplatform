<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model;
use ApiPlatform\Core\OpenApi\OpenApi;
use ArrayObject;

final class JwtDecorator implements OpenApiFactoryInterface
{
    private OpenApiFactoryInterface $decorated;

    public function __construct(
        OpenApiFactoryInterface $decorated
    ) {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Token'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ]);
        $schemas['Credentials'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'email' => [
                    'type' => 'string',
                    'example' => 'johndoe@example.com',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'apassword',
                ],
            ],
        ]);

        $pathItem = new Model\PathItem(
            'JWT Token',         // Ref
            null,                // Summary
            null,                // Description
            null,                // Operation GET
            null,                // Operation PUT
            new Model\Operation( // Operation POST
                'postCredentialsItem', // OperationId
                ['Authentication'],                    // Tags
                [                      // Responses
                    '200' => [
                        'description' => 'Get JWT token',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Token',
                                ],
                            ],
                        ],
                    ],
                ],
                'Get JWT token to login.', // Summary
                '',                        // Description
                null,                      // External Docs
                [],                        // Parameters
                new Model\RequestBody(     // RequestBody
                    'Generate new JWT Token',           // Description
                    new ArrayObject([                   // Content
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials',
                            ],
                        ],
                    ]),
                    false                               // Required
                ),
                null,                      // Callbacks
                false,                     // Deprecated
                null,                      // Security
                null,                      // Servers
            ),
            null,                // Operation DELETE
            null,                // Operation OPTIONS
            null,                // Operation HEAD
            null,                // Operation PATCH
            null,                // Operation TRACE
            null,                // Servers
            [],                  // Parameters
        );
        $openApi->getPaths()->addPath('/api/login_check', $pathItem);

        return $openApi;
    }
}
