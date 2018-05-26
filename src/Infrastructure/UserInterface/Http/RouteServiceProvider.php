<?php

namespace Gks\Infrastructure\UserInterface\Http;

use Gks\Infrastructure\UserInterface\Http\Controllers\Admin\DashboardController;
use Gks\Infrastructure\UserInterface\Http\Controllers\Admin\WorkImagesController;
use Gks\Infrastructure\UserInterface\Http\Controllers\Admin\WorksController;
use Gks\Infrastructure\UserInterface\Http\Controllers\ImagesController;
use Gks\Infrastructure\UserInterface\Http\Middleware\AuthorizationMiddleware;
use Gks\Infrastructure\UserInterface\Http\Middleware\CsrfMiddleware;
use Gks\Infrastructure\UserInterface\Http\Middleware\GuestMiddleware;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\LoginPageRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\LoginRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\LogoutRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\HomeRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\ServeImageRequestHandler;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteCollection;
use League\Route\RouteGroup;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\EmitterInterface;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

class RouteServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        ServerRequestInterface::class,
        ResponseInterface::class,
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
        $this->container->share(EmitterInterface::class, SapiEmitter::class);

        $this->container->share(ServerRequestInterface::class, function () {
            $request = ServerRequestFactory::fromGlobals();
            $path = $request->getUri()->getPath();
            $parsedBody = $request->getParsedBody();

            if ($request->getMethod() === 'POST' && array_key_exists('_method', $parsedBody)) {
                $request = $request->withMethod(strtoupper($parsedBody['_method']));
            }

            return $path === '/' ? $request : $request->withUri($request->getUri()->withPath(rtrim($path, '/')));
        });

        $this->container->share(ResponseInterface::class, Response::class);

        $this->container->share(RouteCollection::class, function () {
            $route = new RouteCollection($this->container);

            $route->middleware($this->container->get(CsrfMiddleware::class));

            $route->get('/', $this->container->get(HomeRequestHandler::class));

            $route->get('/login', $this->container->get(LoginPageRequestHandler::class))
                ->middleware($this->container->get(GuestMiddleware::class));
            $route->post('/login', $this->container->get(LoginRequestHandler::class))
                ->middleware($this->container->get(GuestMiddleware::class));
            $route->get('/logout', $this->container->get(LogoutRequestHandler::class))
                ->middleware($this->container->get(AuthorizationMiddleware::class));

            $route->get('/image/{path}', $this->container->get(ServeImageRequestHandler::class));

            $route->group('/admin', function (RouteGroup $route) {
                $route->get('/', [DashboardController::class, 'index']);
                $route->get('/works', $this->container->get(RequestHandlers\Admin\Works\IndexRequestHandler::class));
                $route->get('/works/create', $this->container->get(RequestHandlers\Admin\Works\AddRequestHandler::class));
                $route->post('/works', [WorksController::class, 'store'])->setName('admin.works.store');
                $route->get('/works/{id}/edit', $this->container->get(RequestHandlers\Admin\Works\EditRequestHandler::class));
                $route->put('/works/{id}', [WorksController::class, 'update']);
                $route->get('/works/{id}/destroy', [WorksController::class, 'destroy']);
                $route->get('/works/{id}/images', [WorkImagesController::class, 'index']);
                $route->post('/works/{id}/images', $this->container->get(RequestHandlers\Admin\Works\StoreImageRequestHandler::class));
                $route->post('/works/{work_id}/images/{image_id}', $this->container->get(RequestHandlers\Admin\Works\RemoveImageRequestHandler::class));
            })->middleware($this->container->get(AuthorizationMiddleware::class));

            return $route;
        });
    }
}
