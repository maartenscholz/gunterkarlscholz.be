<?php

namespace Gks\Infrastructure\UserInterface\Http;

use Aura\Session\Session;
use Aura\Session\SessionFactory;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;

class SessionServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    protected $provides = [
        Session::class,
    ];

    public function register(): void
    {
        $this->container->share(Session::class, function () {
            $sessionFactory = new SessionFactory();

            $session = $sessionFactory->newInstance($_COOKIE);

            $session->setCookieParams([
                'secure' => getenv('APP_ENV') !== 'dev',
                'httponly' => true,
            ]);

            return $session;
        });
    }
}
