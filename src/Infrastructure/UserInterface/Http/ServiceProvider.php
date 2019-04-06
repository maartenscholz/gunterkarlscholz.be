<?php

namespace Gks\Infrastructure\UserInterface\Http;

use Aura\Session\Session;
use Gks\Domain\Model\Works\WorksRepository;
use Gks\Infrastructure\UserInterface\Http\Middleware;
use Gks\Infrastructure\UserInterface\Http\RequestHandlers;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\FilesystemInterface;
use League\Glide\Server;
use League\Glide\Signatures\Signature;
use League\Plates\Engine;
use League\Tactician\CommandBus;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    protected $provides = [
        RequestHandlers\HomeRequestHandler::class,
        RequestHandlers\ServeImageRequestHandler::class,
        RequestHandlers\Admin\LoginPageRequestHandler::class,
        RequestHandlers\Admin\LoginRequestHandler::class,
        RequestHandlers\Admin\LogoutRequestHandler::class,
        RequestHandlers\Admin\DashboardRequestHandler::class,
        RequestHandlers\Admin\Works\IndexRequestHandler::class,
        RequestHandlers\Admin\Works\AddRequestHandler::class,
        RequestHandlers\Admin\Works\StoreRequestHandler::class,
        RequestHandlers\Admin\Works\EditRequestHandler::class,
        RequestHandlers\Admin\Works\UpdateRequestHandler::class,
        RequestHandlers\Admin\Works\DestroyRequestHandler::class,
        RequestHandlers\Admin\Works\Images\IndexRequestHandler::class,
        RequestHandlers\Admin\Works\Images\StoreRequestHandler::class,
        RequestHandlers\Admin\Works\Images\RemoveRequestHandler::class,
        Middleware\CsrfMiddleware::class,
        Middleware\AuthorizationMiddleware::class,
        Middleware\GuestMiddleware::class,
    ];

    public function register(): void
    {
        $this->registerMiddleware();
        $this->registerRequestHandlers();
    }

    private function registerMiddleware(): void
    {
        $this->container->share(Middleware\AuthorizationMiddleware::class, function () {
            return new Middleware\AuthorizationMiddleware(
                $this->container->get(Session::class)->getSegment('authentication'),
                '/login'
            );
        });

        $this->container->share(Middleware\GuestMiddleware::class, function () {
            return new Middleware\GuestMiddleware(
                $this->container->get(Session::class)->getSegment('authentication'),
                '/admin'
            );
        });

        $this->container->share(Middleware\CsrfMiddleware::class, function () {
            return new Middleware\CsrfMiddleware(
                $this->container->get(Session::class),
                $this->container->get(Engine::class)
            );
        });
    }

    private function registerRequestHandlers(): void
    {
        $this->container->share(RequestHandlers\HomeRequestHandler::class, function () {
            return new RequestHandlers\HomeRequestHandler($this->container->get(Engine::class));
        });

        $this->container->share(RequestHandlers\ServeImageRequestHandler::class, function () {
            return new RequestHandlers\ServeImageRequestHandler(
                $this->container->get(Server::class),
                $this->container->get(Signature::class)
            );
        });

        $this->container->share(RequestHandlers\Admin\LoginPageRequestHandler::class, function () {
            return new RequestHandlers\Admin\LoginPageRequestHandler(
                $this->container->get(Session::class)->getSegment('authentication'),
                $this->container->get(Engine::class)
            );
        });

        $this->container->share(RequestHandlers\Admin\LoginRequestHandler::class, function () {
            return new RequestHandlers\Admin\LoginRequestHandler(
                $this->container->get(Session::class)->getSegment('authentication')
            );
        });

        $this->container->share(RequestHandlers\Admin\LogoutRequestHandler::class, function () {
            return new RequestHandlers\Admin\LogoutRequestHandler(
                $this->container->get(Session::class)->getSegment('authentication')
            );
        });

        $this->container->share(RequestHandlers\Admin\DashboardRequestHandler::class, function () {
            return new RequestHandlers\Admin\DashboardRequestHandler($this->container->get(Engine::class));
        });

        $this->container->share(RequestHandlers\Admin\Works\IndexRequestHandler::class, function () {
            return new RequestHandlers\Admin\Works\IndexRequestHandler(
                $this->container->get(Engine::class),
                $this->container->get(WorksRepository::class)
            );
        });

        $this->container->share(RequestHandlers\Admin\Works\AddRequestHandler::class, function () {
            return new RequestHandlers\Admin\Works\AddRequestHandler($this->container->get(Engine::class));
        });

        $this->container->share(RequestHandlers\Admin\Works\StoreRequestHandler::class, function () {
            return new RequestHandlers\Admin\Works\StoreRequestHandler(
                $this->container->get(Session::class)->getSegment('validation'),
                $this->container->get(CommandBus::class)
            );
        });

        $this->container->share(RequestHandlers\Admin\Works\EditRequestHandler::class, function () {
            return new RequestHandlers\Admin\Works\EditRequestHandler(
                $this->container->get(Engine::class),
                $this->container->get(WorksRepository::class)
            );
        });

        $this->container->share(RequestHandlers\Admin\Works\UpdateRequestHandler::class, function () {
            return new RequestHandlers\Admin\Works\UpdateRequestHandler(
                $this->container->get(Session::class)->getSegment('validation'),
                $this->container->get(CommandBus::class)
            );
        });

        $this->container->share(RequestHandlers\Admin\Works\DestroyRequestHandler::class, function () {
            return new RequestHandlers\Admin\Works\DestroyRequestHandler($this->container->get(CommandBus::class));
        });

        $this->container->share(RequestHandlers\Admin\Works\Images\IndexRequestHandler::class, function () {
            return new RequestHandlers\Admin\Works\Images\IndexRequestHandler(
                $this->container->get(Engine::class),
                $this->container->get(WorksRepository::class)
            );
        });

        $this->container->share(RequestHandlers\Admin\Works\Images\StoreRequestHandler::class, function () {
            return new RequestHandlers\Admin\Works\Images\StoreRequestHandler(
                $this->container->get(CommandBus::class),
                $this->container->get(FilesystemInterface::class)
            );
        });

        $this->container->share(RequestHandlers\Admin\Works\Images\RemoveRequestHandler::class, function () {
            return new RequestHandlers\Admin\Works\Images\RemoveRequestHandler($this->container->get(CommandBus::class));
        });
    }
}
