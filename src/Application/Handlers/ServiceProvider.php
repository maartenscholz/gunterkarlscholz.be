<?php

namespace Gks\Application\Handlers;

use BigName\EventDispatcher\Dispatcher;
use Gks\Domain\Model\Works\WorksRepository;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var array
     */
    protected $provides = [
        AddWork::class,
        UpdateWork::class,
        RemoveWork::class,
        AddImage::class,
        RemoveImage::class,
    ];

    public function register(): void
    {
        $this->container->share(AddWork::class, function () {
            return new AddWork($this->container->get(WorksRepository::class));
        });

        $this->container->share(UpdateWork::class, function () {
            return new UpdateWork($this->container->get(WorksRepository::class));
        });

        $this->container->share(RemoveWork::class, function () {
            return new RemoveWork(
                $this->container->get(WorksRepository::class),
                $this->container->get(Dispatcher::class)
            );
        });

        $this->container->share(AddImage::class, function () {
            return new AddImage($this->container->get(WorksRepository::class));
        });

        $this->container->share(RemoveImage::class, function () {
            return new RemoveImage(
                $this->container->get(WorksRepository::class),
                $this->container->get(Dispatcher::class)
            );
        });
    }
}
