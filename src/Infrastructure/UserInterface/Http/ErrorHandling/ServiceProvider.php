<?php

namespace Gks\Infrastructure\UserInterface\Http\ErrorHandling;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Plates\Engine;
use Psr\Log\LoggerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

final class ServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Run::class,
    ];

    public function register(): void
    {
        $this->leagueContainer->share(
            Run::class,
            function () {
                $whoops = new Run();

                $whoops->appendHandler(new LoggingHandler($this->container->get(LoggerInterface::class)));

                if (getenv('APP_ENV') !== 'production') {
                    $handler = new PrettyPageHandler();

                    $handler->setPageTitle('Whoops.');

                    $whoops->appendHandler($handler);
                }

                $whoops->appendHandler(new ErrorPageHandler($this->container->get(Engine::class)));

                return $whoops;
            }
        );
    }
}
