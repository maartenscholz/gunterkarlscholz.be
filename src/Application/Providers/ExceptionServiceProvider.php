<?php

namespace Gks\Application\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class ExceptionServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Method will be invoked on registration of a service provider implementing
     * this interface. Provides ability for eager loading of Service Providers.
     *
     * @return void
     */
    public function boot()
    {
        $run = new Run();
        $handler = new PrettyPageHandler();

        $handler->setPageTitle('Whoops.');

        $run->pushHandler($handler);

        $run->register();
    }
}
