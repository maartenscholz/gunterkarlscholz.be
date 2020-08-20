<?php

namespace Gks\Infrastructure\Api\Http\RequestHandlers;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;

final class RootRequestHandler
{
    public function __invoke(): ResponseInterface
    {
        return new JsonResponse(
            [
                'data' => [
                    'name' => 'gunterkarlscholz.be public API',
                ],
            ]
        );
    }
}
