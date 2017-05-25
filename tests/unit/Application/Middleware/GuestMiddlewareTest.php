<?php

namespace Gks\Tests\Unit\Application\Middleware;

use Aura\Session\Segment;
use Gks\Application\Http\Middleware\GuestMiddleware;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class GuestMiddlewareTest extends TestCase
{
    /**
     * @var Segment|PHPUnit_Framework_MockObject_MockObject
     */
    private $session;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * @var ServerRequestInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $request;

    /**
     * @var ResponseInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $response;

    /**
     * @var callable
     */
    private $next;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->session = $this->createMock(Segment::class);
        $this->redirectUri = 'redirect_uri';
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->next = function () { return 'response'; };
    }

    /**
     * @test
     */
    public function it_returns_the_callable_result_when_not_authenticated()
    {
        $this->session->method('get')->with('authenticated')->willReturn(false);

        $middleware = new GuestMiddleware($this->session, $this->redirectUri);

        $result = $middleware($this->request, $this->response, $this->next);

        $this->assertEquals('response', $result);
    }

    /**
     * @test
     */
    public function it_returns_a_redirect_response_when_authenticated()
    {
        $this->session->method('get')->with('authenticated')->willReturn(true);

        $middleware = new GuestMiddleware($this->session, $this->redirectUri);

        $result = $middleware($this->request, $this->response, $this->next);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals($result->getHeader('Location'), ['redirect_uri']);
    }
}
