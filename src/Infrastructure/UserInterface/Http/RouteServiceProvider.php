<?php

namespace Gks\Infrastructure\UserInterface\Http;

use Gks\Infrastructure\UserInterface\Http\Middleware;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteCollection;
use League\Route\RouteGroup;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouteServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        RouteCollection::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->container->share(RouteCollection::class, function () {
            $route = new RouteCollection($this->container);

            $route->middleware($this->container->get(Middleware\CsrfMiddleware::class));

            $route->get('/', $this->container->get(RequestHandlers\HomeRequestHandler::class));

            $route->get('/login', $this->container->get(RequestHandlers\Admin\LoginPageRequestHandler::class))
                ->middleware($this->container->get(Middleware\GuestMiddleware::class));
            $route->post('/login', $this->container->get(RequestHandlers\Admin\LoginRequestHandler::class))
                ->middleware($this->container->get(Middleware\GuestMiddleware::class));
            $route->get('/logout', $this->container->get(RequestHandlers\Admin\LogoutRequestHandler::class))
                ->middleware($this->container->get(Middleware\AuthorizationMiddleware::class));

            $route->get('/image/{path}', $this->container->get(RequestHandlers\ServeImageRequestHandler::class));

            $route->group('/admin', function (RouteGroup $route) {
                $route->get('/', $this->container->get(RequestHandlers\Admin\DashboardRequestHandler::class));
                $route->get('/works', $this->container->get(RequestHandlers\Admin\Works\IndexRequestHandler::class));
                $route->get('/works/create', $this->container->get(RequestHandlers\Admin\Works\AddRequestHandler::class));
                $route->post('/works', $this->container->get(RequestHandlers\Admin\Works\StoreRequestHandler::class));
                $route->get('/works/{id}/edit', $this->container->get(RequestHandlers\Admin\Works\EditRequestHandler::class));
                $route->put('/works/{id}', $this->container->get(RequestHandlers\Admin\Works\UpdateRequestHandler::class));
                $route->get('/works/{id}/destroy', $this->container->get(RequestHandlers\Admin\Works\DestroyRequestHandler::class));
                $route->get('/works/{id}/images', $this->container->get(RequestHandlers\Admin\Works\Images\IndexRequestHandler::class));
                $route->post('/works/{id}/images', $this->container->get(RequestHandlers\Admin\Works\Images\StoreRequestHandler::class));
                $route->post('/works/{work_id}/images/{image_id}', $this->container->get(RequestHandlers\Admin\Works\Images\RemoveRequestHandler::class));
            })->middleware($this->container->get(Middleware\AuthorizationMiddleware::class));

            return $route;
        });
    }
}
