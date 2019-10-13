<?php

namespace Gks\Infrastructure\Http;

use Closure;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

final class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        EmitterInterface::class,
        ServerRequestInterface::class,
        ResponseInterface::class,
        ApplicationRequestHandler::class,
        'ServerRequestFactory',
        'ServerRequestErrorResponseGenerator',
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->container->share(EmitterInterface::class, SapiEmitter::class);

        $this->container->share(
            ServerRequestInterface::class,
            function () {
                $request = ServerRequestFactory::fromGlobals();
                $path = $request->getUri()->getPath();
                $parsedBody = $request->getParsedBody();

                if ($request->getMethod() === 'POST' && array_key_exists('_method', $parsedBody)) {
                    $request = $request->withMethod(strtoupper($parsedBody['_method']));
                }

                return $path === '/' ? $request : $request->withUri($request->getUri()->withPath(rtrim($path, '/')));
            }
        );

        $this->container->share(ResponseInterface::class, Response::class);

        $this->container->share(
            ApplicationRequestHandler::class,
            function () {
                return new ApplicationRequestHandler($this->container->get(Router::class));
            }
        );

        $this->container->share(
            'ServerRequestFactory',
            function () {
                return Closure::fromCallable(
                    function () {
                        return $this->container->get(ServerRequestInterface::class);
                    }
                );
            }
        );

        $this->container->share(
            'ServerRequestErrorResponseGenerator',
            function () {
                return Closure::fromCallable(
                    function () {
                        return $this->container->get(ResponseInterface::class)->withStatus(500);
                    }
                );
            }
        );
    }
}
