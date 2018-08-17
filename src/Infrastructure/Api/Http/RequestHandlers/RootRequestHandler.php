<?php

namespace Gks\Infrastructure\Api\Http\RequestHandlers;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

class RootRequestHandler
{
    /**
     * @return ResponseInterface
     */
    public function __invoke()
    {
        return new JsonResponse([
            'data' => [
                'name' => 'gunterkarlschoz.be public API',
            ],
        ]);
    }
}
