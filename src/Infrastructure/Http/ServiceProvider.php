<?php

namespace Gks\Infrastructure\Http;

use Closure;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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

    public function register(): void
    {
        $this->leagueContainer->share(EmitterInterface::class, SapiEmitter::class);

        $this->leagueContainer->share(
            ServerRequestInterface::class,
            static function () {
                $request = ServerRequestFactory::fromGlobals();
                $path = $request->getUri()->getPath();
                $parsedBody = $request->getParsedBody();

                if ($request->getMethod() === 'POST' && array_key_exists('_method', $parsedBody)) {
                    $request = $request->withMethod(strtoupper($parsedBody['_method']));
                }

                return $path === '/' ? $request : $request->withUri($request->getUri()->withPath(rtrim($path, '/')));
            }
        );

        $this->leagueContainer->share(ResponseInterface::class, Response::class);

        $this->leagueContainer->share(
            ApplicationRequestHandler::class,
            function () {
                return new ApplicationRequestHandler($this->container->get(Router::class));
            }
        );

        $this->leagueContainer->share(
            'ServerRequestFactory',
            function () {
                return Closure::fromCallable(
                    function () {
                        return $this->container->get(ServerRequestInterface::class);
                    }
                );
            }
        );

        $this->leagueContainer->share(
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
