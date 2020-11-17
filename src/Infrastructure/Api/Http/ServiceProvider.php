<?php

namespace Gks\Infrastructure\Api\Http;

use Gks\Infrastructure\Api\Http\RequestHandlers\RootRequestHandler;
use Gks\Infrastructure\Http\ResponseFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use League\Route\Strategy\JsonStrategy;

final class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Router::class,
    ];

    public function register(): void
    {
        $this->leagueContainer->share(
            Router::class,
            static function () {
                $router = new Router();

                $router->setStrategy(new JsonStrategy(new ResponseFactory()));

                $router->get('/', new RootRequestHandler());

                return $router;
            }
        );
    }
}
