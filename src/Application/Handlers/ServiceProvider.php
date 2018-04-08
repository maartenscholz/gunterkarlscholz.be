<?php

namespace Gks\Application\Handlers;

use Gks\Domain\Works\Images\ImageRepository;
use Gks\Domain\Works\WorksRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\FilesystemInterface;

class ServiceProvider extends AbstractServiceProvider
{
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

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->container->share(AddWork::class, function () {
            return new AddWork($this->container->get(WorksRepository::class));
        });

        $this->container->share(UpdateWork::class, function () {
            return new UpdateWork($this->container->get(WorksRepository::class));
        });

        $this->container->share(RemoveWork::class, function () {
            return new RemoveWork($this->container->get(WorksRepository::class));
        });

        $this->container->share(AddImage::class, function () {
            return new AddImage(
                $this->container->get(ImageRepository::class),
                $this->container->get(WorksRepository::class)
            );
        });

        $this->container->share(RemoveImage::class, function () {
            return new RemoveImage(
                $this->container->get(ImageRepository::class),
                $this->container->get(FilesystemInterface::class)
            );
        });
    }
}
