<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin;

use Aura\Session\Segment;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class LoginRequestHandler
{
    private Segment $session;

    public function __construct(Segment $session)
    {
        $this->session = $session;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $credentials = (array) $request->getParsedBody();

        if (!array_key_exists('username', $credentials) || !array_key_exists('password', $credentials)) {
            throw new BadRequestException();
        }

        if ($credentials['username'] === 'admin' && $credentials['password'] === getenv('APP_ADMIN_PASSWORD')) {
            $this->session->set('authenticated', true);

            return new RedirectResponse('/admin');
        }

        $this->session->setFlash('message', 'Invalid credentials');
        $this->session->setFlash('input', $credentials);

        return new RedirectResponse('/login');
    }
}
