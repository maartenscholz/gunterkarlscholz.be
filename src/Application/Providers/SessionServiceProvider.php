<?php

namespace Gks\Application\Providers;

use Aura\Session\Session;
use Aura\Session\SessionFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;

class SessionServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Session::class,
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
        $this->container->share(Session::class, function () {
            $sessionFactory = new SessionFactory();

            return $sessionFactory->newInstance($_COOKIE);
        });
    }
}
