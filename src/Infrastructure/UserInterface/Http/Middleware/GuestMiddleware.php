<?php

namespace Gks\Infrastructure\UserInterface\Http\Middleware;

use Aura\Session\Segment;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class GuestMiddleware
{
    /**
     * @var Segment
     */
    private $session;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * AuthorizationMiddleware constructor.
     *
     * @param Segment $session
     * @param string $redirectUri
     */
    public function __construct(Segment $session, $redirectUri)
    {
        $this->session = $session;
        $this->redirectUri = $redirectUri;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        if (!$this->session->get('authenticated', false)) {
            return $next($request, $response);
        }

        return new RedirectResponse($this->redirectUri);
    }
}
