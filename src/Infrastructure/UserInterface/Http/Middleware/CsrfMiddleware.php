<?php

namespace Gks\Infrastructure\UserInterface\Http\Middleware;

use Aura\Session\CsrfToken;
use Aura\Session\Session;
use InvalidArgumentException;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CsrfMiddleware implements MiddlewareInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var Engine
     */
    private $templates;

    public function __construct(Session $session, Engine $templates)
    {
        $this->session = $session;
        $this->templates = $templates;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $csrfToken = $this->session->getCsrfToken();
        $this->templates->addData(['csrf_token' => $csrfToken->getValue()]);

        if ($this->requestNeedsToBeValidated($request)) {
            $parsedBody = (array) $request->getParsedBody();

            if ($this->requestHasCsrfToken($parsedBody)) {
                if (!$this->csrfTokenIsValid($csrfToken, $parsedBody['_csrf_token'])) {
                    throw new InvalidArgumentException('Invalid csrf token.');
                }
            } else {
                throw new InvalidArgumentException('No _csrf_token attribute found.');
            }
        }

        return $handler->handle($request);
    }

    private function requestNeedsToBeValidated(ServerRequestInterface $request): bool
    {
        return in_array($request->getMethod(), ['POST', 'PUT', 'PATCH', 'DELETE'], true);
    }

    private function requestHasCsrfToken(array $parsedBody): bool
    {
        return array_key_exists('_csrf_token', $parsedBody);
    }

    private function csrfTokenIsValid(CsrfToken $csrfToken, string $requestToken): bool
    {
        return $csrfToken->isValid($requestToken);
    }
}
