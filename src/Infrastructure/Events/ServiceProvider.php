use Gks\Application\Listeners\RemoveImageFiles;
use Gks\Domain\Events\ImageWasRemoved;

            $dispatcher->addLazyListener(ImageWasRemoved::class, RemoveImageFiles::class);
