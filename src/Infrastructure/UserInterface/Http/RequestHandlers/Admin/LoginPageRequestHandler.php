<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin;

use Aura\Session\Segment;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

final class LoginPageRequestHandler
{
    private Segment $session;

    private Engine $templates;

    public function __construct(Segment $session, Engine $templates)
    {
        $this->session = $session;
        $this->templates = $templates;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        $response->getBody()->write(
            $this->templates->render(
                'admin::auth/login',
                [
                    'message' => $this->session->getFlash('message'),
                    'input' => $this->session->getFlash('input'),
                ]
            )
        );

        return $response;
    }
}
