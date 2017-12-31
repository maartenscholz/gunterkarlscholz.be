<?php

namespace Gks\Application\Providers;

use Gks\Application\ErrorHandling\ErrorPageHandler;
use Gks\Application\ErrorHandling\LoggingHandler;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Plates\Engine;
use Psr\Log\LoggerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class ExceptionServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Run::class,
        ErrorPageHandler::class,
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

            $whoops->pushHandler($this->container->get(ErrorPageHandler::class));

            if (getenv('APP_ENV') !== 'production') {
                $handler = new PrettyPageHandler();

                $handler->setPageTitle('Whoops.');

                $whoops->pushHandler($handler);
            }

            $whoops->pushHandler($this->container->get(LoggingHandler::class));

            return $whoops;
        });

        $this->container->share(ErrorPageHandler::class, function () {
            return new ErrorPageHandler($this->container->get(Engine::class));
        });

        $this->container->share(LoggingHandler::class, function () {
            return new LoggingHandler($this->container->get(LoggerInterface::class));
        });
    }
}
