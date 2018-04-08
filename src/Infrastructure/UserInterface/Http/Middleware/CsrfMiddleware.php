<?php

namespace Gks\Infrastructure\UserInterface\Http\Middleware;

use Aura\Session\Session;
use InvalidArgumentException;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CsrfMiddleware
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var Engine
     */
    private $templates;

    /**
     * CsrfMiddleware constructor.
     *
     * @param Session $session
     * @param Engine $templates
     */
    public function __construct(Session $session, Engine $templates)
    {
        $this->session = $session;
        $this->templates = $templates;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $csrfToken = $this->session->getCsrfToken();
        $this->templates->addData(['csrf_token' => $csrfToken->getValue()]);

        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            if (array_key_exists('_csrf_token', $request->getParsedBody())) {
                if (!$csrfToken->isValid($request->getParsedBody()['_csrf_token'])) {
                    throw new InvalidArgumentException('Invalid csrf token.');
                }
            } else {
                throw new InvalidArgumentException('No _csrf_token attribute found.');
            }
        }

        return $next($request, $response);
    }
}
