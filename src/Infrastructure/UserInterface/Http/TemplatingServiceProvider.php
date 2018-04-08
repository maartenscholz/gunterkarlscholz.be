<?php

namespace Gks\Infrastructure\UserInterface\Http;

use Aura\Session\Segment;
use Aura\Session\Session;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Glide\Urls\UrlBuilder;
use League\Plates\Engine;

class TemplatingServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Engine::class,
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
        $this->container->share(Engine::class, function () {
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

            return $engine;
        });
    }
}
