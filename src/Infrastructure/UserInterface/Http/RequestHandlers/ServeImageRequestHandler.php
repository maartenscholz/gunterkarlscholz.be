<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers;

use Laminas\Diactoros\Response;
use League\Glide\Server;
use League\Glide\Signatures\Signature;
use League\Glide\Signatures\SignatureException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode;

final class ServeImageRequestHandler
{
    private Server $glide;

    private Signature $glideSignature;

    public function __construct(Server $glide, Signature $glideSignature)
    {
        $this->glide = $glide;
        $this->glideSignature = $glideSignature;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        try {
            $this->glideSignature->validateRequest($args['path'], $request->getQueryParams());
        } catch (SignatureException $e) {
            $response = new Response();

            $response->getBody()->write('Nice try.');

            return $response->withStatus(StatusCode::FORBIDDEN);
        }

        return $this->glide->getImageResponse($args['path'], $request->getQueryParams());
    }
}
