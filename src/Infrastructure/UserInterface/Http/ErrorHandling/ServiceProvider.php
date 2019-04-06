<?php

namespace Gks\Infrastructure\UserInterface\Http\ErrorHandling;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Plates\Engine;
use Psr\Log\LoggerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    protected $provides = [
        Run::class,
        ErrorPageHandler::class,
    ];

    public function register(): void
    {
        $this->container->share(
            Run::class,
            function () {
                $whoops = new Run();

                $whoops->pushHandler($this->container->get(ErrorPageHandler::class));

                if (getenv('APP_ENV') !== 'production') {
                    $handler = new PrettyPageHandler();

                    $handler->setPageTitle('Whoops.');

                    $whoops->pushHandler($handler);
                }

                $whoops->pushHandler($this->container->get(LoggingHandler::class));

                return $whoops;
            }
        );

        $this->container->share(
            ErrorPageHandler::class,
            function () {
                return new ErrorPageHandler($this->container->get(Engine::class));
            }
        );

        $this->container->share(
            LoggingHandler::class,
            function () {
                return new LoggingHandler($this->container->get(LoggerInterface::class));
            }
        );
    }
}
