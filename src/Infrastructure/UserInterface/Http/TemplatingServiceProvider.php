<?php

namespace Gks\Infrastructure\UserInterface\Http;

use Aura\Session\Segment;
use Aura\Session\Session;
use DebugBar\DebugBar;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Glide\Urls\UrlBuilder;
use League\Plates\Engine;

class TemplatingServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    protected $provides = [
        Engine::class,
    ];

    public function register(): void
    {
        $this->container->share(
            Engine::class,
            function () {
                /** @var Segment $authenticationSession */
                $authenticationSession = $this->container->get(Session::class)->getSegment('authentication');
                /** @var Segment $validationSession */
                $validationSession = $this->container->get(Session::class)->getSegment('validation');

                $engine = new Engine(__DIR__.'/../../../../resources/templates');

                $engine->addFolder('admin', $engine->getDirectory().DIRECTORY_SEPARATOR.'admin');

                $engine->addData(['authenticated' => $authenticationSession->get('authenticated', false)]);
                $engine->addData(['errors' => $validationSession->getFlash('errors', [])]);
                $engine->addData(['input' => $validationSession->getFlash('input', [])]);
                $engine->addData(['imageUrlBuilder' => $this->container->get(UrlBuilder::class)]);

                if (getenv('APP_ENV') === 'dev') {
                    $engine->addData(['debugBar' => $this->container->get(DebugBar::class)->getJavascriptRenderer()]);
                }

                return $engine;
            }
        );
    }
}
