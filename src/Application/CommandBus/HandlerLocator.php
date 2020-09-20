<?php

namespace Gks\Application\CommandBus;

use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator as HandlerLocatorContract;
use Psr\Container\ContainerInterface;

final class HandlerLocator implements HandlerLocatorContract
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Retrieves the handler for a specified command.
     *
     * @param string $commandName
     *
     * @throws MissingHandlerException
     *
     * @return object
     */
    public function getHandlerForCommand($commandName)
    {
        $handlerName = str_replace('Commands', 'Handlers', $commandName);

        return $this->container->get($handlerName);
    }
}
