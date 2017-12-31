<?php

namespace Gks\Application\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class ExceptionServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Run::class,
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
        $this->container->share(Run::class, function () {
            $whoops = new Run();
            $handler = new PrettyPageHandler();

            $handler->setPageTitle('Whoops.');

            $whoops->pushHandler($handler);

            return $whoops;
        });
    }
}
