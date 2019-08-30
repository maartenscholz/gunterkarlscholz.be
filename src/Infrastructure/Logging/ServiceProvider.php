<?php

namespace Gks\Infrastructure\Logging;

use DebugBar\Bridge\DoctrineCollector;
use DebugBar\DataCollector\MemoryCollector;
use DebugBar\DataCollector\PhpInfoCollector;
use DebugBar\DataCollector\TimeDataCollector;
use DebugBar\DebugBar;
use Doctrine\ORM\EntityManagerInterface;
use Gks\Infrastructure\Logging\Monolog\SentryHandler;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Sentry\Client;
use Sentry\ClientBuilder;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    protected $provides = [
        LoggerInterface::class,
        Client::class,
        DebugBar::class,
    ];

    public function register(): void
    {
        $this->container->share(
            LoggerInterface::class,
            function () {
                $log = new Logger('main');

                $log->pushHandler(new RotatingFileHandler(realpath(__DIR__.'/../../../storage/logs').'/error.log', 5));

                if (getenv('APP_ENV') === 'production') {
                    $log->pushHandler(new SentryHandler($this->container->get(Client::class)));
                }

                return $log;
            }
        );

        $this->container->share(
            Client::class,
            function () {
                return ClientBuilder::create(
                    [
                        'environment' => getenv('APP_ENV'),
                    ]
                )->getClient();
            }
        );

        $this->container->share(
            DebugBar::class,
            function () {
                $debugBar = new DebugBar();

                $debugBar->addCollector(new PhpInfoCollector());
                $debugBar->addCollector(new MemoryCollector());
                $debugBar->addCollector(new TimeDataCollector());
                $debugBar->addCollector(new DoctrineCollector($this->container->get(EntityManagerInterface::class)));

                return $debugBar;
            }
        );
    }
}
