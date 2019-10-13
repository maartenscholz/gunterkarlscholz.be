<?php

namespace Gks\Infrastructure\UserInterface\Http\ErrorHandling;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Plates\Engine;
use Psr\Log\LoggerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

final class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    protected $provides = [
        Run::class,
    ];

    public function register(): void
    {
        $this->container->share(
            Run::class,
            function () {
                $whoops = new Run();

                $whoops->appendHandler(new ErrorPageHandler($this->container->get(Engine::class)));

                if (getenv('APP_ENV') !== 'production') {
                    $handler = new PrettyPageHandler();

                    $handler->setPageTitle('Whoops.');

                    $whoops->appendHandler($handler);
                }

                $whoops->appendHandler(new LoggingHandler($this->container->get(LoggerInterface::class)));

                return $whoops;
            }
        );
    }
}
