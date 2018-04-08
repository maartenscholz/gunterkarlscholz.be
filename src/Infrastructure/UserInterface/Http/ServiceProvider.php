<?php

namespace Gks\Infrastructure\UserInterface\Http;

use Aura\Session\Session;
use Gks\Domain\Works\WorksRepository;
use Gks\Infrastructure\UserInterface\Http\Controllers\Admin\DashboardController;
use Gks\Infrastructure\UserInterface\Http\Controllers\Admin\WorkImagesController;
use Gks\Infrastructure\UserInterface\Http\Controllers\Admin\WorksController;
use Gks\Infrastructure\UserInterface\Http\Controllers\HomeController;
use Gks\Infrastructure\UserInterface\Http\Controllers\ImagesController;
use Gks\Infrastructure\UserInterface\Http\Middleware\AuthorizationMiddleware;
use Gks\Infrastructure\UserInterface\Http\Middleware\CsrfMiddleware;
use Gks\Infrastructure\UserInterface\Http\Middleware\GuestMiddleware;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\LoginPageRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\LoginRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\LogoutRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\AddRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\EditRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\IndexRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\RemoveImageRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\StoreImageRequestHandler;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\FilesystemInterface;
use League\Glide\Server;
use League\Glide\Signatures\Signature;
use League\Plates\Engine;
use League\Tactician\CommandBus;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        LoginPageRequestHandler::class,
        LoginRequestHandler::class,
        LogoutRequestHandler::class,
        HomeController::class,
        ImagesController::class,
        DashboardController::class,
        WorksController::class,
        WorkImagesController::class,
        IndexRequestHandler::class,
        AddRequestHandler::class,
        EditRequestHandler::class,
        RemoveImageRequestHandler::class,
        CsrfMiddleware::class,
        AuthorizationMiddleware::class,
        GuestMiddleware::class,
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->registerControllers();
        $this->registerMiddleware();
        $this->registerRequestHandlers();
    }

    /**
     * @return void
     */
    private function registerControllers()
    {
        $this->container->share(HomeController::class, function () {
            return new HomeController($this->container->get(Engine::class));
        });

        $this->container->share(ImagesController::class, function () {
            return new ImagesController($this->container->get(Server::class), $this->container->get(Signature::class));
        });

        $this->container->share(DashboardController::class, function () {
            return new DashboardController($this->container->get(Engine::class));
        });

        $this->container->share(WorksController::class, function () {
            return new WorksController(
                $this->container->get(CommandBus::class),
                $this->container->get(Session::class)->getSegment('validation')
            );
        });

        $this->container->share(WorkImagesController::class, function () {
            return new WorkImagesController(
                $this->container->get(Engine::class),
                $this->container->get(WorksRepository::class)
            );
        });
    }

    /**
     * @return void
     */
    private function registerMiddleware()
    {
        $this->container->share(AuthorizationMiddleware::class, function () {
            return new AuthorizationMiddleware(
                $this->container->get(Session::class)->getSegment('authentication'),
                '/login'
            );
        });

        $this->container->share(GuestMiddleware::class, function () {
            return new GuestMiddleware(
                $this->container->get(Session::class)->getSegment('authentication'),
                '/admin'
            );
        });

        $this->container->share(CsrfMiddleware::class, function () {
            return new CsrfMiddleware(
                $this->container->get(Session::class),
                $this->container->get(Engine::class)
            );
        });
    }

    /**
     * @return void
     */
    private function registerRequestHandlers()
    {
        $this->container->share(LoginPageRequestHandler::class, function () {
            return new LoginPageRequestHandler(
                $this->container->get(Session::class)->getSegment('authentication'),
                $this->container->get(Engine::class)
            );
        });

        $this->container->share(LoginRequestHandler::class, function () {
            return new LoginRequestHandler($this->container->get(Session::class)->getSegment('authentication'));
        });

        $this->container->share(LogoutRequestHandler::class, function () {
            return new LogoutRequestHandler($this->container->get(Session::class)->getSegment('authentication'));
        });

        $this->container->share(IndexRequestHandler::class, function () {
            return new IndexRequestHandler(
                $this->container->get(Engine::class),
                $this->container->get(WorksRepository::class)
            );
        });

        $this->container->share(AddRequestHandler::class, function () {
            return new AddRequestHandler($this->container->get(Engine::class));
        });

        $this->container->share(EditRequestHandler::class, function () {
            return new EditRequestHandler(
                $this->container->get(Engine::class),
                $this->container->get(WorksRepository::class)
            );
        });

        $this->container->share(StoreImageRequestHandler::class, function () {
            return new StoreImageRequestHandler(
                $this->container->get(CommandBus::class),
                $this->container->get(FilesystemInterface::class)
            );
        });

        $this->container->share(RemoveImageRequestHandler::class, function () {
            return new RemoveImageRequestHandler($this->container->get(CommandBus::class));
        });
    }
}