<?php

namespace Gks\Infrastructure\Logging;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Monolog\Handler\NullHandler;
use Monolog\Handler\RavenHandler;
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

            if (getenv('APP_ENV') === 'production') {
                $log->pushHandler(new RavenHandler($this->container->get(Raven_Client::class)));
            } else {
                $log->pushHandler(new NullHandler());
            }

            return $log;
        });

        $this->container->share(Raven_Client::class, function () {
            return new Raven_Client(getenv('SENTRY_DSN'), [
                'environment' => getenv('APP_ENV'),
            ]);
        });
    }
}
