<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers;

use League\Glide\Server;
use League\Glide\Signatures\Signature;
use League\Glide\Signatures\SignatureException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode;

class ServeImageRequestHandler
{
    /**
     * @var Server
     */
    private $glide;

    /**
     * @var Signature
     */
    private $glideSignature;

    /**
     * @param Server $glide
     * @param Signature $glideSignature
     */
    public function __construct(Server $glide, Signature $glideSignature)
    {
        $this->glide = $glide;
        $this->glideSignature = $glideSignature;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        try {
            $this->glideSignature->validateRequest($args['path'], $request->getQueryParams());
        } catch (SignatureException $e) {
            $response->getBody()->write('Nice try.');

            return $response->withStatus(StatusCode::FORBIDDEN);
        }

        return $this->glide->getImageResponse($args['path'], $request->getQueryParams());
    }
}
