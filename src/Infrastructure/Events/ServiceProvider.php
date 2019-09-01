<?php

namespace Gks\Infrastructure\Events;

use BigName\EventDispatcher\Dispatcher;
use Gks\Application\Listeners\RemoveImageFiles;
use Gks\Domain\Events\ImageWasRemoved;
use Gks\Infrastructure\Events\BigName\PsrContainerAdapter;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;

final class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    protected $provides = [
        Dispatcher::class,
    ];

    public function register(): void
    {
        $this->container->share(Dispatcher::class, function () {
            $dispatcher = new Dispatcher(new PsrContainerAdapter($this->container));

            $dispatcher->addLazyListener(ImageWasRemoved::class, RemoveImageFiles::class);

            return $dispatcher;
        });
    }
}