<?php

namespace Gks\Application\Providers;

use Gks\Application\Http\Controllers\Admin\DashboardController;
use Gks\Application\Http\Controllers\Admin\SessionController;
use Gks\Application\Http\Controllers\Admin\WorkImagesController;
use Gks\Application\Http\Controllers\Admin\WorksController;
use Gks\Application\Http\Controllers\HomeController;
use Gks\Application\Http\Controllers\ImagesController;
use Gks\Application\Http\Middleware\AuthorizationMiddleware;
use Gks\Application\Http\Middleware\GuestMiddleware;
use Gks\Application\Http\MiddlewareStrategy;
use Gks\Application\Http\RequestHandlers\Admin\Works;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteCollection;
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
        MiddlewareStrategy::class,
    ];

    /**
     * @var array
     */
    protected $routeMiddleware = [
        'session.create' => [GuestMiddleware::class],
        'session.store' => [GuestMiddleware::class],
        'session.destroy' => [AuthorizationMiddleware::class],
        'admin.*' => [AuthorizationMiddleware::class],
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
            $route->setStrategy($this->container->get(MiddlewareStrategy::class));

            $route->get('/', [HomeController::class, 'index'])->setName('home');
            $route->get('/login', [SessionController::class, 'create'])->setName('session.create');
            $route->post('/login', [SessionController::class, 'store'])->setName('session.store');
            $route->get('/logout', [SessionController::class, 'destroy'])->setName('session.destroy');

            $route->get('image/{path}', [ImagesController::class, 'show'])->setName('images.show');

            $route->get('/admin', [DashboardController::class, 'index'])->setName('admin.dashboard');
            $route->get('/admin/works', $this->container->get(Works\IndexRequestHandler::class))->setName('admin.works.index');
            $route->get('/admin/works/create', [WorksController::class, 'create'])->setName('admin.works.create');
            $route->post('/admin/works', [WorksController::class, 'store'])->setName('admin.works.store');
            $route->get('/admin/works/{id}/edit', [WorksController::class, 'edit'])->setName('admin.works.edit');
            $route->put('/admin/works/{id}', [WorksController::class, 'update'])->setName('admin.works.update');
            $route->get('/admin/works/{id}/destroy', [WorksController::class, 'destroy'])->setName('admin.works.destroy');
            $route->get('/admin/works/{id}/images', [WorkImagesController::class, 'index'])->setName('admin.works.images.index');
            $route->post('/admin/works/{id}/images', [WorkImagesController::class, 'store'])->setName('admin.works.images.store');
            $route->post('/admin/works/{work_id}/images/{image_id}', $this->container->get(Works\RemoveImageRequestHandler::class))->setName('admin.images.destroy');

            return $route;
        });

        $this->container->share(MiddlewareStrategy::class, function () {
            $strategy = new MiddlewareStrategy($this->routeMiddleware);
            $strategy->setContainer($this->container);

            return $strategy;
        });
    }
}
