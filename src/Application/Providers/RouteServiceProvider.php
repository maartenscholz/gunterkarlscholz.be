<?php

namespace Gks\Application\Providers;

use Gks\Application\Http\Controllers\Admin\DashboardController;
use Gks\Application\Http\Controllers\Admin\WorkImagesController;
use Gks\Application\Http\Controllers\Admin\WorksController;
use Gks\Application\Http\Controllers\HomeController;
use Gks\Application\Http\Controllers\ImagesController;
use Gks\Application\Http\Middleware\AuthorizationMiddleware;
use Gks\Application\Http\Middleware\CsrfMiddleware;
use Gks\Application\Http\Middleware\GuestMiddleware;
use Gks\Application\Http\RequestHandlers\Admin\LoginPageRequestHandler;
use Gks\Application\Http\RequestHandlers\Admin\LoginRequestHandler;
use Gks\Application\Http\RequestHandlers\Admin\LogoutRequestHandler;
use Gks\Application\Http\RequestHandlers\Admin\Works;
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

            $route->get('/', [HomeController::class, 'index'])->setName('home');

            $route->get('/login', $this->container->get(LoginPageRequestHandler::class))
                ->middleware($this->container->get(GuestMiddleware::class));
            $route->post('/login', $this->container->get(LoginRequestHandler::class))
                ->middleware($this->container->get(GuestMiddleware::class));
            $route->get('/logout', $this->container->get(LogoutRequestHandler::class))
                ->middleware($this->container->get(AuthorizationMiddleware::class));

            $route->get('/image/{path}', [ImagesController::class, 'show'])->setName('images.show');

            $route->group('/admin', function (RouteGroup $route) {
                $route->get('/', [DashboardController::class, 'index']);
                $route->get('/works', $this->container->get(Works\IndexRequestHandler::class));
                $route->get('/works/create', $this->container->get(Works\AddRequestHandler::class));
                $route->post('/works', [WorksController::class, 'store'])->setName('admin.works.store');
                $route->get('/works/{id}/edit', $this->container->get(Works\EditRequestHandler::class));
                $route->put('/works/{id}', [WorksController::class, 'update']);
                $route->get('/works/{id}/destroy', [WorksController::class, 'destroy']);
                $route->get('/works/{id}/images', [WorkImagesController::class, 'index']);
                $route->post('/works/{id}/images', $this->container->get(Works\StoreImageRequestHandler::class));
                $route->post('/works/{work_id}/images/{image_id}', $this->container->get(Works\RemoveImageRequestHandler::class));
            })->middleware($this->container->get(AuthorizationMiddleware::class));

            return $route;
        });
    }
}
