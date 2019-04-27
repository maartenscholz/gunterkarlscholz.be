<?php

namespace Gks\Application\Listeners;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\FilesystemInterface;

final class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    protected $provides = [
        RemoveImageFiles::class,
    ];

    public function register(): void
    {
        $this->container->share(
            RemoveImageFiles::class,
            function () {
                return new RemoveImageFiles($this->container->get(FilesystemInterface::class));
            }
        );
    }
}
