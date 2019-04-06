<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin;

use Aura\Session\Segment;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class LoginRequestHandler
{
    /**
     * @var Segment
     */
    private $session;

    public function __construct(Segment $session)
    {
        $this->session = $session;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $credentials = $request->getParsedBody();

        if ($credentials['username'] === 'admin' && $credentials['password'] === getenv('APP_ADMIN_PASSWORD')) {
            $this->session->set('authenticated', true);

            return new RedirectResponse('/admin');
        }

        $this->session->setFlash('message', 'Invalid credentials');
        $this->session->setFlash('input', $credentials);

        return new RedirectResponse('/login');
    }
}
