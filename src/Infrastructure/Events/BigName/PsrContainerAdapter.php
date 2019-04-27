<?php

namespace Gks\Infrastructure\Events\BigName;

use BigName\EventDispatcher\Containers\Container;
use Psr\Container\ContainerInterface;

final class PsrContainerAdapter implements Container
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function make($class)
    {
        return $this->container->get($class);
    }
}
