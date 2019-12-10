<?php

namespace Gks\Infrastructure\Api\Http\RequestHandlers;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

final class RootRequestHandler
{
    public function __invoke(): ResponseInterface
    {
        return new JsonResponse([
            'data' => [
                'name' => 'gunterkarlscholz.be public API',
            ],
        ]);
    }
}
