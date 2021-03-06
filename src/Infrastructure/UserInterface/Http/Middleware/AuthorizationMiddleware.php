<?php

namespace Gks\Infrastructure\UserInterface\Http\Middleware;

use Aura\Session\Segment;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class AuthorizationMiddleware implements MiddlewareInterface
{
    private Segment $session;

    private string $redirectUri;

    public function __construct(Segment $session, $redirectUri)
    {
        $this->session = $session;
        $this->redirectUri = $redirectUri;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->session->get('authenticated', false)) {
            return $handler->handle($request);
        }

        return new RedirectResponse($this->redirectUri);
    }
}
