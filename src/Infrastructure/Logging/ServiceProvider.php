<?php

namespace Gks\Infrastructure\Logging;

use DebugBar\Bridge\DoctrineCollector;
use DebugBar\DataCollector\MemoryCollector;
use DebugBar\DataCollector\PhpInfoCollector;
use DebugBar\DataCollector\TimeDataCollector;
use DebugBar\DebugBar;
use Doctrine\ORM\EntityManagerInterface;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Sentry\ClientBuilder;
use Sentry\Monolog\Handler;
use Sentry\SentrySdk;
use Sentry\State\Hub;
use Sentry\State\HubInterface;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    protected $provides = [
        LoggerInterface::class,
        HubInterface::class,
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
                    $log->pushHandler(new Handler($this->container->get(HubInterface::class)));
                }

                return $log;
            }
        );

        $this->container->share(
            HubInterface::class,
            static function () {
                $client = ClientBuilder::create(
                    [
                        'dsn' => getenv('SENTRY_DSN'),
                        'environment' => getenv('APP_ENV'),
                    ]
                )->getClient();

                $hub = new Hub($client);

                SentrySdk::setCurrentHub($hub);

                return $hub;
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
