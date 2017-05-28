<?php

namespace Gks\Application\Http\RequestHandlers\Admin\Works;

use Gks\Domain\Works\Images\Commands\AddImage;
use Gks\Domain\Works\Images\ImageId;
use Gks\Domain\Works\WorkId;
use League\Flysystem\FilesystemInterface;
use League\Tactician\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\UploadedFile;

class StoreImageRequestHandler
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @param CommandBus $commandBus
     * @param FilesystemInterface $filesystem
     */
    public function __construct(CommandBus $commandBus, FilesystemInterface $filesystem)
    {
        $this->commandBus = $commandBus;
        $this->filesystem = $filesystem;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $workId = WorkId::fromString($args['id']);
        $imageId = ImageId::generate();

        /** @var UploadedFile $image */
        $image = $request->getUploadedFiles()['image'];

        $this->filesystem->writeStream('images/source/'.$imageId.'_'.$image->getClientFilename(), $image->getStream()->detach());

        $this->commandBus->handle(new AddImage($workId, $imageId, $image->getClientFilename()));

        return $response->withHeader('Location', '/admin/works/'.$workId.'/images');
    }
}
