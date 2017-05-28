<?php

namespace Gks\Application\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;

class FilesystemServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        FilesystemInterface::class,
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->container->share(FilesystemInterface::class, function () {
            $adapter = new Local(__DIR__.'/../../../storage');

            return new Filesystem($adapter);
        });
    }
}
