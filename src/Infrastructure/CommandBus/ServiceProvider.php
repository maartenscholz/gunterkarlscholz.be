<?php

namespace Gks\Infrastructure\CommandBus;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;

final class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        CommandBus::class,
    ];

    public function register(): void
    {
        $this->leagueContainer->share(
            CommandBus::class,
            function () {
                $handlerMiddleware = new CommandHandlerMiddleware(
                    new ClassNameExtractor(),
                    new HandlerLocator($this->container),
                    new HandleInflector()
                );

                return new CommandBus(
                    [
                        $handlerMiddleware,
                    ]
                );
            }
        );
    }
}
