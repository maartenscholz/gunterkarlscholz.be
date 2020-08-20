<?php

namespace Gks\Infrastructure\Filesystem;

use Gks\Infrastructure\Filesystem\EventListeners\RemoveImageFiles;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;

final class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        FilesystemInterface::class,
        RemoveImageFiles::class,
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->container->share(
            FilesystemInterface::class,
            static function () {
                $adapter = new Local(__DIR__.'/../../../storage');

                return new Filesystem($adapter);
            }
        );

        $this->container->share(
            RemoveImageFiles::class,
            function () {
                return new RemoveImageFiles($this->container->get(FilesystemInterface::class));
            }
        );
    }
}
