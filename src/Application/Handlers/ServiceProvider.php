<?php

namespace Gks\Application\Handlers;

use BigName\EventDispatcher\Dispatcher;
use Gks\Domain\Model\Works\WorksRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;
use function Clue\StreamFilter\fun;

final class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        ViewWorks::class,
        ViewWork::class,
        ViewWorkBySlug::class,
        AddWork::class,
        UpdateWork::class,
        RemoveWork::class,
        AddImage::class,
        RemoveImage::class,
    ];

    public function register(): void
    {
        $this->leagueContainer->share(
            ViewWorks::class,
            function () {
                return new ViewWorks($this->container->get(WorksRepository::class));
            }
        );

        $this->leagueContainer->share(
            ViewWork::class,
            function () {
                return new ViewWork($this->container->get(WorksRepository::class));
            }
        );

        $this->leagueContainer->share(
            ViewWorkBySlug::class,
            function () {
                return new ViewWorkBySlug($this->container->get(WorksRepository::class));
            }
        );

        $this->leagueContainer->share(
            AddWork::class,
            function () {
                return new AddWork($this->container->get(WorksRepository::class));
            }
        );

        $this->leagueContainer->share(
            UpdateWork::class,
            function () {
                return new UpdateWork($this->container->get(WorksRepository::class));
            }
        );

        $this->leagueContainer->share(
            RemoveWork::class,
            function () {
                return new RemoveWork(
                    $this->container->get(WorksRepository::class),
                    $this->container->get(Dispatcher::class)
                );
            }
        );

        $this->leagueContainer->share(
            AddImage::class,
            function () {
                return new AddImage($this->container->get(WorksRepository::class));
            }
        );

        $this->leagueContainer->share(
            RemoveImage::class,
            function () {
                return new RemoveImage(
                    $this->container->get(WorksRepository::class),
                    $this->container->get(Dispatcher::class)
                );
            }
        );
    }
}
