<?php

namespace Gks\Infrastructure\Persistence\MySQL;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\PredisCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Predis\ClientInterface;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        EntityManager::class,
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->container->share(EntityManager::class, function () {
            $config = new Configuration();

            $config->setProxyDir(__DIR__.'/../../../../storage/doctrine/proxies');
            $config->setProxyNamespace('App\Doctrine\Proxies');
            $config->setAutoGenerateProxyClasses(getenv('APP_ENV') === 'dev');

            $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver([
                __DIR__.'/../../../Domain/Model',
            ]));

            if (getenv('APP_ENV') === 'dev') {
                $config->setMetadataCacheImpl(new ArrayCache());
            } else {
                $config->setMetadataCacheImpl(new PredisCache($this->container->get(ClientInterface::class)));
            }

            $connectionConfig = [
                'driver' => 'pdo_mysql',
                'host' => getenv('MYSQL_HOST'),
                'port' => getenv('MYSQL_PORT'),
                'dbname' => getenv('MYSQL_DATABASE'),
                'user' => getenv('MYSQL_USERNAME'),
                'password' => getenv('MYSQL_PASSWORD'),
                'charset' => 'utf8',
            ];

            return EntityManager::create($connectionConfig, $config);
        });
    }
}
