<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin;

use Aura\Session\Segment;
use Zend\Diactoros\Response\RedirectResponse;

class LogoutRequestHandler
{
    /**
     * @var Segment
     */
    private $session;

    /**
     * @param Segment $session
     */
    public function __construct(Segment $session)
    {
        $this->session = $session;
    }

    /**
     * @return RedirectResponse
     */
    public function __invoke()
    {
        $this->session->set('authenticated', false);

        return new RedirectResponse('/');
    }
}
