<?php

namespace Gks\Infrastructure\UserInterface\Http;

use Laminas\Diactoros\Stream;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Glide\Responses\PsrResponseFactory;
use League\Glide\Server;
use League\Glide\ServerFactory;
use League\Glide\Signatures\Signature;
use League\Glide\Signatures\SignatureFactory;
use League\Glide\Urls\UrlBuilder;
use League\Glide\Urls\UrlBuilderFactory;
use Psr\Http\Message\ResponseInterface;

class GlideServiceProvider extends AbstractServiceProvider
{
    /**
     * @var Container
     */
    protected $container;

    protected $provides = [
        Server::class,
        Signature::class,
        UrlBuilder::class,
    ];

    public function register(): void
    {
        $this->container->share(
            Server::class,
            function () {
                return ServerFactory::create(
                    [
                        'source' => __DIR__.'/../../../../storage/images/source',
                        'cache' => __DIR__.'/../../../../storage/images/cache',
                        'response' => new PsrResponseFactory(
                            $this->container->get(ResponseInterface::class),
                            function ($stuff) {
                                $stream = new Stream($stuff);

                                return $stream;
                            }
                        ),
                    ]
                );
            }
        );

        $this->container->share(
            Signature::class,
            function () {
                return SignatureFactory::create(getenv('GLIDE_SIGNATURE_KEY'));
            }
        );

        $this->container->share(
            UrlBuilder::class,
            function () {
                return UrlBuilderFactory::create('', getenv('GLIDE_SIGNATURE_KEY'));
            }
        );
    }
}
