<?php

namespace Gks\Infrastructure\UserInterface\Http;

use Gks\Infrastructure\UserInterface\Http\Middleware;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteGroup;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;

final class RoutingServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Router::class,
    ];

    public function register(): void
    {
        $this->leagueContainer->share(
            Router::class,
            function () {
                $strategy = new ApplicationStrategy();

                $strategy->setContainer($this->container);

                $router = new Router();

                $router->setStrategy($strategy);

                $router->middleware($this->container->get(Middleware\CsrfMiddleware::class));

                $router->get('/', RequestHandlers\HomeRequestHandler::class);

                $router->get('/login', RequestHandlers\Admin\LoginPageRequestHandler::class)
                    ->middleware($this->container->get(Middleware\GuestMiddleware::class));
                $router->post('/login', RequestHandlers\Admin\LoginRequestHandler::class)
                    ->middleware($this->container->get(Middleware\GuestMiddleware::class));
                $router->get('/logout', RequestHandlers\Admin\LogoutRequestHandler::class)
                    ->middleware($this->container->get(Middleware\AuthorizationMiddleware::class));

                $router->get('/image/{path}', RequestHandlers\ServeImageRequestHandler::class);

                $router->get('/portfolio', RequestHandlers\Works\Index::class);
                $router->get('/portfolio/work/{id}', RequestHandlers\Works\Show::class);
                $router->get('/about', RequestHandlers\AboutRequestHandler::class);

                $router->group(
                    '/admin',
                    function (RouteGroup $router) {
                        $router->get('/', RequestHandlers\Admin\DashboardRequestHandler::class);
                        $router->get('/works', RequestHandlers\Admin\Works\IndexRequestHandler::class);
                        $router->get('/works/create', RequestHandlers\Admin\Works\AddRequestHandler::class);
                        $router->post('/works', RequestHandlers\Admin\Works\StoreRequestHandler::class);
                        $router->get('/works/{id}/edit', RequestHandlers\Admin\Works\EditRequestHandler::class);
                        $router->put('/works/{id}', RequestHandlers\Admin\Works\UpdateRequestHandler::class);
                        $router->get('/works/{id}/destroy', RequestHandlers\Admin\Works\DestroyRequestHandler::class);
                        $router->get(
                            '/works/{id}/images',
                            RequestHandlers\Admin\Works\Images\IndexRequestHandler::class
                        );
                        $router->post(
                            '/works/{id}/images',
                            RequestHandlers\Admin\Works\Images\StoreRequestHandler::class
                        );
                        $router->post(
                            '/works/{work_id}/images/{image_id}',
                            RequestHandlers\Admin\Works\Images\RemoveRequestHandler::class
                        );
                    }
                )->middleware($this->container->get(Middleware\AuthorizationMiddleware::class));

                return $router;
            }
        );
    }
}
