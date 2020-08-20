<?php

namespace Gks\Infrastructure\Events;

use BigName\EventDispatcher\Dispatcher;
use Gks\Domain\Events\ImageWasRemoved;
use Gks\Infrastructure\Events\BigName\PsrContainerAdapter;
use Gks\Infrastructure\Filesystem\EventListeners\RemoveImageFiles;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;

final class ServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Dispatcher::class,
    ];

    public function register(): void
    {
        $this->leagueContainer->share(
            Dispatcher::class,
            function () {
                $dispatcher = new Dispatcher(new PsrContainerAdapter($this->container));

                $dispatcher->addLazyListener(ImageWasRemoved::class, RemoveImageFiles::class);

                return $dispatcher;
            }
        );
    }
}
