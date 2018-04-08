<?php

namespace Gks\Application\Http\RequestHandlers\Admin;

use Aura\Session\Segment;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginPageRequestHandler
{
    /**
     * @var Segment
     */
    private $session;

    /**
     * @var Engine
     */
    private $templates;

    /**
     * @param Segment $session
     * @param Engine $templates
     */
    public function __construct(Segment $session, Engine $templates)
    {
        $this->session = $session;
        $this->templates = $templates;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response->getBody()->write($this->templates->render('admin::auth/login', [
            'message' => $this->session->getFlash('message'),
            'input' => $this->session->getFlash('input'),
        ]));

        return $response;
    }
}
