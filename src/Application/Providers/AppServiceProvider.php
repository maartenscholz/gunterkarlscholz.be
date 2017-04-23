<?php

namespace Gks\Application\Providers;

use Aura\Session\Session;
use Gks\Application\Http\Controllers\Admin;
use Gks\Application\Http\Controllers\HomeController;
use Gks\Application\Http\Controllers\ImagesController;
use Gks\Domain\Works\WorksRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Glide\Server;
use League\Glide\Signatures\Signature;
use League\Plates\Engine;
use League\Tactician\CommandBus;

class AppServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        HomeController::class,
        ImagesController::class,
        Admin\SessionController::class,
        Admin\DashboardController::class,
        Admin\WorksController::class,
        Admin\WorkImagesController::class,
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
        $this->container->share(HomeController::class, function () {
            return new HomeController($this->container->get(Engine::class));
        });

        $this->container->share(ImagesController::class, function () {
            return new ImagesController($this->container->get(Server::class), $this->container->get(Signature::class));
        });

        $this->container->share(Admin\SessionController::class, function () {
            return new Admin\SessionController(
                $this->container->get(Session::class)->getSegment('authentication'),
                $this->container->get(Engine::class)
            );
        });

        $this->container->share(Admin\DashboardController::class, function () {
            return new Admin\DashboardController($this->container->get(Engine::class));
        });

        $this->container->share(Admin\WorksController::class, function () {
            return new Admin\WorksController(
                $this->container->get(Engine::class),
                $this->container->get(WorksRepository::class),
                $this->container->get(CommandBus::class),
                $this->container->get(Session::class)->getSegment('validation')
            );
        });

        $this->container->share(Admin\WorkImagesController::class, function () {
            return new Admin\WorkImagesController(
                $this->container->get(Engine::class),
                $this->container->get(WorksRepository::class)
            );
        });
    }
}
