<?php

namespace Gks\Infrastructure\UserInterface\Http;

use DebugBar\DebugBar;
use Gks\Infrastructure\UserInterface\Http\Middleware;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteGroup;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Zend\Diactoros\Response;

final class RouteServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    protected $provides = [
        Router::class,
    ];

    public function register(): void
    {
        $this->container->share(
            Router::class,
            function () {
                $strategy = new ApplicationStrategy();

                $strategy->setContainer($this->container);

                $route = new Router();

                $route->setStrategy($strategy);

                $route->middleware($this->container->get(Middleware\CsrfMiddleware::class));

                $route->get('/', RequestHandlers\HomeRequestHandler::class);

                $route->get('/login', RequestHandlers\Admin\LoginPageRequestHandler::class)
                    ->middleware($this->container->get(Middleware\GuestMiddleware::class));
                $route->post('/login', RequestHandlers\Admin\LoginRequestHandler::class)
                    ->middleware($this->container->get(Middleware\GuestMiddleware::class));
                $route->get('/logout', RequestHandlers\Admin\LogoutRequestHandler::class)
                    ->middleware($this->container->get(Middleware\AuthorizationMiddleware::class));

                $route->get('/image/{path}', RequestHandlers\ServeImageRequestHandler::class);

                $route->get('/portfolio', RequestHandlers\Works\Index::class);

                $route->group(
                    '/admin',
                    function (RouteGroup $route) {
                        $route->get('/', RequestHandlers\Admin\DashboardRequestHandler::class);
                        $route->get('/works', RequestHandlers\Admin\Works\IndexRequestHandler::class);
                        $route->get('/works/create', RequestHandlers\Admin\Works\AddRequestHandler::class);
                        $route->post('/works', RequestHandlers\Admin\Works\StoreRequestHandler::class);
                        $route->get('/works/{id}/edit', RequestHandlers\Admin\Works\EditRequestHandler::class);
                        $route->put('/works/{id}', RequestHandlers\Admin\Works\UpdateRequestHandler::class);
                        $route->get('/works/{id}/destroy', RequestHandlers\Admin\Works\DestroyRequestHandler::class);
                        $route->get(
                            '/works/{id}/images',
                            RequestHandlers\Admin\Works\Images\IndexRequestHandler::class
                        );
                        $route->post(
                            '/works/{id}/images',
                            RequestHandlers\Admin\Works\Images\StoreRequestHandler::class
                        );
                        $route->post(
                            '/works/{work_id}/images/{image_id}',
                            RequestHandlers\Admin\Works\Images\RemoveRequestHandler::class
                        );
                    }
                )->middleware($this->container->get(Middleware\AuthorizationMiddleware::class));

                if (getenv('APP_ENV') === 'dev') {
                    $route->get(
                        '/debugbar/css',
                        function () {
                            $response = new Response();

                            $debugBar = $this->container->get(DebugBar::class);

                            $response->getBody()->write(
                                $debugBar->getJavascriptRenderer()->getAsseticCollection('css')->dump()
                            );

                            return $response->withHeader('Content-Type', 'text/css');
                        }
                    );
                    $route->get(
                        '/debugbar/js',
                        function () {
                            $response = new Response();
                            $debugBar = $this->container->get(DebugBar::class);

                            $javascriptRenderer = $debugBar->getJavascriptRenderer();

                            $response->getBody()->write($javascriptRenderer->getAsseticCollection('js')->dump());

                            return $response->withHeader('Content-Type', 'text/javascript');
                        }
                    );
                }

                return $route;
            }
        );
    }
}
