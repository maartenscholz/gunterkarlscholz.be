<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works;

use Gks\Application\Commands\AddImage;
use Gks\Domain\Model\Works\Images\ImageId;
use Gks\Domain\Model\Works\WorkId;
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

        $filename = $imageId.'_'.$image->getClientFilename();
        $this->filesystem->writeStream("images/source/$filename", $image->getStream()->detach());

        $this->commandBus->handle(new AddImage($workId, $imageId, $filename, $image->getClientFilename()));

        return $response->withHeader('Location', "/admin/works/$workId/images");
    }
}
