<?php

namespace Gks\Application\Providers;

use Aura\Session\Session;
use Gks\Application\Http\Middleware\AuthorizationMiddleware;
use Gks\Application\Http\Middleware\CsrfMiddleware;
use Gks\Application\Http\Middleware\GuestMiddleware;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Plates\Engine;

class AuthServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        AuthorizationMiddleware::class,
        GuestMiddleware::class,
        CsrfMiddleware::class,
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
        $this->container->share(AuthorizationMiddleware::class, function () {
            return new AuthorizationMiddleware(
                $this->container->get(Session::class)->getSegment('authentication'),
                '/login'
            );
        });

        $this->container->share(GuestMiddleware::class, function () {
            return new GuestMiddleware(
                $this->container->get(Session::class)->getSegment('authentication'),
                '/admin'
            );
        });

        $this->container->share(CsrfMiddleware::class, function () {
            return new CsrfMiddleware(
                $this->container->get(Session::class),
                $this->container->get(Engine::class)
            );
        });
    }
}
