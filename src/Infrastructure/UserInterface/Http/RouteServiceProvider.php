<?php

namespace Gks\Infrastructure\UserInterface\Http;

use DebugBar\DebugBar;
use Gks\Infrastructure\UserInterface\Http\Middleware;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteGroup;
use League\Route\Router;
use Zend\Diactoros\Response;

class RouteServiceProvider extends AbstractServiceProvider
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
                $route = new Router();

                $route->middleware($this->container->get(Middleware\CsrfMiddleware::class));

                $route->get('/', $this->container->get(RequestHandlers\HomeRequestHandler::class));

                $route->get('/login', $this->container->get(RequestHandlers\Admin\LoginPageRequestHandler::class))
                    ->middleware($this->container->get(Middleware\GuestMiddleware::class));
                $route->post('/login', $this->container->get(RequestHandlers\Admin\LoginRequestHandler::class))
                    ->middleware($this->container->get(Middleware\GuestMiddleware::class));
                $route->get('/logout', $this->container->get(RequestHandlers\Admin\LogoutRequestHandler::class))
                    ->middleware($this->container->get(Middleware\AuthorizationMiddleware::class));

                $route->get('/image/{path}', $this->container->get(RequestHandlers\ServeImageRequestHandler::class));

                $route->get('/portfolio', $this->container->get(RequestHandlers\Works\Index::class));

                $route->group(
                    '/admin',
                    function (RouteGroup $route) {
                        $route->get('/', $this->container->get(RequestHandlers\Admin\DashboardRequestHandler::class));
                        $route->get(
                            '/works',
                            $this->container->get(RequestHandlers\Admin\Works\IndexRequestHandler::class)
                        );
                        $route->get(
                            '/works/create',
                            $this->container->get(RequestHandlers\Admin\Works\AddRequestHandler::class)
                        );
                        $route->post(
                            '/works',
                            $this->container->get(RequestHandlers\Admin\Works\StoreRequestHandler::class)
                        );
                        $route->get(
                            '/works/{id}/edit',
                            $this->container->get(RequestHandlers\Admin\Works\EditRequestHandler::class)
                        );
                        $route->put(
                            '/works/{id}',
                            $this->container->get(RequestHandlers\Admin\Works\UpdateRequestHandler::class)
                        );
                        $route->get(
                            '/works/{id}/destroy',
                            $this->container->get(RequestHandlers\Admin\Works\DestroyRequestHandler::class)
                        );
                        $route->get(
                            '/works/{id}/images',
                            $this->container->get(RequestHandlers\Admin\Works\Images\IndexRequestHandler::class)
                        );
                        $route->post(
                            '/works/{id}/images',
                            $this->container->get(RequestHandlers\Admin\Works\Images\StoreRequestHandler::class)
                        );
                        $route->post(
                            '/works/{work_id}/images/{image_id}',
                            $this->container->get(RequestHandlers\Admin\Works\Images\RemoveRequestHandler::class)
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
