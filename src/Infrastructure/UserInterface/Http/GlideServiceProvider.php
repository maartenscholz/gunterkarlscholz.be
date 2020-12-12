<?php

namespace Gks\Infrastructure\UserInterface\Http;

use Laminas\Diactoros\Stream;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Glide\Responses\PsrResponseFactory;
use League\Glide\Server;
use League\Glide\ServerFactory;
use League\Glide\Signatures\Signature;
use League\Glide\Signatures\SignatureFactory;
use League\Glide\Urls\UrlBuilder;
use League\Glide\Urls\UrlBuilderFactory;
use Psr\Http\Message\ResponseInterface;

final class GlideServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Server::class,
        Signature::class,
        UrlBuilder::class,
    ];

    public function register(): void
    {
        $this->leagueContainer->share(
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

        $this->leagueContainer->share(
            Signature::class,
            static function () {
                return SignatureFactory::create($_ENV['GLIDE_SIGNATURE_KEY']);
            }
        );

        $this->leagueContainer->share(
            UrlBuilder::class,
            static function () {
                return UrlBuilderFactory::create('', $_ENV['GLIDE_SIGNATURE_KEY']);
            }
        );
    }
}
