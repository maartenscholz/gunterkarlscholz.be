<?php

namespace Gks\Infrastructure\UserInterface\Http;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Glide\Responses\PsrResponseFactory;
use League\Glide\Server;
use League\Glide\ServerFactory;
use League\Glide\Signatures\Signature;
use League\Glide\Signatures\SignatureFactory;
use League\Glide\Urls\UrlBuilder;
use League\Glide\Urls\UrlBuilderFactory;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Stream;

class GlideServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Server::class,
        Signature::class,
        UrlBuilder::class,
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
        $this->container->share(Server::class, function () {
            return ServerFactory::create([
                'source' => __DIR__.'/../../../storage/images/source',
                'cache' => __DIR__.'/../../../storage/images/cache',
                'response' => new PsrResponseFactory(
                    $this->container->get(ResponseInterface::class),
                    function ($stuff) {
                        $stream = new Stream($stuff);
                        return $stream;
                    }
                ),
            ]);
        });

        $this->container->share(Signature::class, function () {
            return SignatureFactory::create(getenv('GLIDE_SIGNATURE_KEY'));
        });

        $this->container->share(UrlBuilder::class, function () {
            return UrlBuilderFactory::create('', getenv('GLIDE_SIGNATURE_KEY'));
        });
    }
}
