<?php

namespace Gks\Application\Http;

use Gks\Application\Http\Middleware\CsrfMiddleware;
use League\Route\Route;
use League\Route\Strategy\AbstractStrategy;
use League\Route\Strategy\StrategyInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\RelayBuilder;

class MiddlewareStrategy extends AbstractStrategy implements StrategyInterface
{
    /**
     * @var array
     */
    private $routeMiddleware;

    /**
     * MiddlewareStrategy constructor.
     *
     * @param array $routeMiddleware
     */
    public function __construct(array $routeMiddleware)
    {
        $this->routeMiddleware = $routeMiddleware;
    }

    /**
     * Dispatch the controller, the return value of this method will bubble out and be
     * returned by \League\Route\Dispatcher::dispatch, it does not require a response, however,
     * beware that there is no output buffering by default in the router
     *
     * This method is passed an optional third argument of the route object itself.
     *
     * @param callable $controller
     * @param array $vars - named wildcard segments of the matched route
     * @param \League\Route\Route|null $route
     *
     * @return ResponseInterface
     */
    public function dispatch(callable $controller, array $vars, Route $route = null)
    {
        $routeMiddleware = [];
        $relayBuilder = new RelayBuilder();

        $defaultMiddleware = [
            $this->container->get(CsrfMiddleware::class),
            function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($controller, $vars) {
                return $next($request, $this->determineResponse(call_user_func_array($controller, [
                    $request,
                    $response,
                    $vars,
                ])));
            },
        ];

        foreach ($this->routeMiddleware as $routeMiddlewarePattern => $middleware) {
            if (preg_match('#^'.$routeMiddlewarePattern.'\z#u', $route->getName())) {
                foreach ($middleware as $middlewareClassName) {
                    $routeMiddleware[] = $this->container->get($middlewareClassName);
                }
            }
        }

        $relay = $relayBuilder->newInstance(array_merge($routeMiddleware, $defaultMiddleware));

        return $relay($this->getRequest(), $this->getResponse());
    }
}
