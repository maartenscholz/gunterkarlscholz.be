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

final class RoutingServiceProvider extends AbstractServiceProvider
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

                if (getenv('APP_ENV') === 'dev') {
                    $router->get(
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
                    $router->get(
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

                return $router;
            }
        );
    }
}
