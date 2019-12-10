<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin;

use Aura\Session\Segment;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\RedirectResponse;

final class LogoutRequestHandler
{
    private Segment $session;

    public function __construct(Segment $session)
    {
        $this->session = $session;
    }

    public function __invoke(): ResponseInterface
    {
        $this->session->set('authenticated', false);

        return new RedirectResponse('/');
    }
}
