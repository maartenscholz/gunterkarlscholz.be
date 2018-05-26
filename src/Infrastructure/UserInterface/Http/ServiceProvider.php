<?php

namespace Gks\Infrastructure\UserInterface\Http;

use Aura\Session\Session;
use Gks\Domain\Works\WorksRepository;
use Gks\Infrastructure\UserInterface\Http\Middleware\AuthorizationMiddleware;
use Gks\Infrastructure\UserInterface\Http\Middleware\CsrfMiddleware;
use Gks\Infrastructure\UserInterface\Http\Middleware\GuestMiddleware;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\DashboardRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\LoginPageRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\LoginRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\LogoutRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\AddRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\DestroyRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\EditRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\ImagesIndexRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\IndexRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\RemoveImageRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\StoreImageRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\StoreRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\UpdateRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\HomeRequestHandler;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers\ServeImageRequestHandler;
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
        HomeRequestHandler::class,
        ServeImageRequestHandler::class,
        DashboardRequestHandler::class,
        IndexRequestHandler::class,
        AddRequestHandler::class,
        StoreRequestHandler::class,
        EditRequestHandler::class,
        UpdateRequestHandler::class,
        DestroyRequestHandler::class,
        ImagesIndexRequestHandler::class,
        StoreImageRequestHandler::class,
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
        $this->registerMiddleware();
        $this->registerRequestHandlers();
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
        $this->container->share(HomeRequestHandler::class, function () {
            return new HomeRequestHandler($this->container->get(Engine::class));
        });

        $this->container->share(ServeImageRequestHandler::class, function () {
            return new ServeImageRequestHandler(
                $this->container->get(Server::class),
                $this->container->get(Signature::class)
            );
        });

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

        $this->container->share(DashboardRequestHandler::class, function () {
            return new DashboardRequestHandler($this->container->get(Engine::class));
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

        $this->container->share(StoreRequestHandler::class, function () {
            return new StoreRequestHandler(
                $this->container->get(Session::class)->getSegment('validation'),
                $this->container->get(CommandBus::class)
            );
        });

        $this->container->share(EditRequestHandler::class, function () {
            return new EditRequestHandler(
                $this->container->get(Engine::class),
                $this->container->get(WorksRepository::class)
            );
        });

        $this->container->share(UpdateRequestHandler::class, function () {
            return new UpdateRequestHandler(
                $this->container->get(Session::class)->getSegment('validation'),
                $this->container->get(CommandBus::class)
            );
        });

        $this->container->share(DestroyRequestHandler::class, function () {
            return new DestroyRequestHandler($this->container->get(CommandBus::class));
        });

        $this->container->share(ImagesIndexRequestHandler::class, function () {
            return new ImagesIndexRequestHandler(
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
