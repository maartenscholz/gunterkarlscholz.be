<?php

namespace Gks\Infrastructure\Api\Http;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RoutingServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        RouteCollection::class,
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->container->share(RouteCollection::class, function () {
            $router = new RouteCollection();

            $router->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
                $response->getBody()->write('API root');

                return $response;
            });

            return $router;
        });
    }
}
