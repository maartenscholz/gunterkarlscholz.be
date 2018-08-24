<?php

namespace Gks\Infrastructure\Logging;

use DebugBar\Bridge\DoctrineCollector;
use DebugBar\DataCollector\MemoryCollector;
use DebugBar\DataCollector\PhpInfoCollector;
use DebugBar\DataCollector\TimeDataCollector;
use DebugBar\DebugBar;
use Doctrine\ORM\EntityManagerInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Monolog\Handler\NullHandler;
use Monolog\Handler\RavenHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Raven_Client;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        LoggerInterface::class,
        Raven_Client::class,
        DebugBar::class,
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
        $this->container->share(LoggerInterface::class, function () {
            $log = new Logger('main');

            $log->pushHandler(new RotatingFileHandler(realpath(__DIR__.'/../../../storage/logs').'/error.log', 5));

            if (getenv('APP_ENV') === 'production') {
                $log->pushHandler(new RavenHandler($this->container->get(Raven_Client::class)));
            }

            return $log;
        });

        $this->container->share(Raven_Client::class, function () {
            return new Raven_Client(getenv('SENTRY_DSN'), [
                'environment' => getenv('APP_ENV'),
            ]);
        });

        $this->container->share(DebugBar::class, function () {
            $debugBar = new DebugBar();

            $debugBar->addCollector(new PhpInfoCollector());
            $debugBar->addCollector(new MemoryCollector());
            $debugBar->addCollector(new TimeDataCollector());
            $debugBar->addCollector(new DoctrineCollector($this->container->get(EntityManagerInterface::class)));

            return $debugBar;
        });
    }
}
