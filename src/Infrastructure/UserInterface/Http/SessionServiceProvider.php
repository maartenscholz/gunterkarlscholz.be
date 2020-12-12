<?php

namespace Gks\Infrastructure\UserInterface\Http;

use Aura\Session\Session;
use Aura\Session\SessionFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;

final class SessionServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Session::class,
    ];

    public function register(): void
    {
        $this->container->share(
            Session::class,
            static function () {
                $sessionFactory = new SessionFactory();

                $session = $sessionFactory->newInstance($_COOKIE);

                $session->setCookieParams(
                    [
                        'secure' => $_ENV['APP_ENV'] !== 'dev',
                        'httponly' => true,
                    ]
                );

                return $session;
            }
        );
    }
}
