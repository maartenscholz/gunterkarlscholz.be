<?php

namespace Gks\Tests\Unit\Application\Middleware;

use Aura\Session\Segment;
use Gks\Infrastructure\UserInterface\Http\Middleware\AuthorizationMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;

class AuthorizationMiddlewareTest extends TestCase
{
    /**
     * @var Segment|MockObject
     */
    private $session;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * @var ServerRequestInterface|MockObject
     */
    private $request;

    /**
     * @var ResponseInterface|MockObject
     */
    private $response;

    /**
     * @var RequestHandlerInterface|MockObject
     */
    private $requestHandler;

    public function setUp(): void
    {
        $this->session = $this->createMock(Segment::class);
        $this->redirectUri = 'redirect_uri';
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->requestHandler = $this->createMock(RequestHandlerInterface::class);
    }

    /**
     * @test
     */
    public function it_returns_the_return_value_of_the_request_handler_when_authenticated()
    {
        $this->session->method('get')->with('authenticated')->willReturn(true);
        $this->requestHandler->method('handle')->with($this->request)->willReturn($this->response);

        $middleware = new AuthorizationMiddleware($this->session, $this->redirectUri);

        $result = $middleware->process($this->request, $this->requestHandler);

        $this->assertEquals($this->response, $result);
    }

    /**
     * @test
     */
    public function it_returns_a_redirect_response_when_not_authenticated()
    {
        $this->session->method('get')->with('authenticated')->willReturn(false);

        $middleware = new AuthorizationMiddleware($this->session, $this->redirectUri);

        $result = $middleware->process($this->request, $this->requestHandler);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals($result->getHeader('Location'), ['redirect_uri']);
    }
}
