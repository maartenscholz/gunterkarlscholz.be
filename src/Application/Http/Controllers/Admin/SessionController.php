<?php

namespace Gks\Application\Http\Controllers\Admin;

use Aura\Session\Segment;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class SessionController
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
    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response->getBody()->write($this->templates->render('admin::auth/login', [
            'message' => $this->session->getFlash('message'),
            'input' => $this->session->getFlash('input'),
        ]));

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return RedirectResponse
     */
    public function store(ServerRequestInterface $request)
    {
        $credentials = $request->getParsedBody();

        if ($credentials['username'] === 'admin' && $credentials['password'] === getenv('APP_ADMIN_PASSWORD')) {
            $this->session->set('authenticated', true);

            return new RedirectResponse('admin');
        }

        $this->session->setFlash('message', 'Invalid credentials');
        $this->session->setFlash('input', $credentials);

        return new RedirectResponse('login');
    }

    /**
     * @return RedirectResponse
     */
    public function destroy()
    {
        $this->session->set('authenticated', false);

        return new RedirectResponse('/');
    }
}
