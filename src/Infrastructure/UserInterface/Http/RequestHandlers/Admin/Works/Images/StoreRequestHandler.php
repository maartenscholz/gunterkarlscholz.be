<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\Images;

use Gks\Application\Commands\AddImage;
use Gks\Domain\Model\Works\Images\ImageId;
use Gks\Domain\Model\Works\WorkId;
use League\Flysystem\FilesystemInterface;
use League\Tactician\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\UploadedFile;

class StoreRequestHandler
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    public function __construct(CommandBus $commandBus, FilesystemInterface $filesystem)
    {
        $this->commandBus = $commandBus;
        $this->filesystem = $filesystem;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $workId = WorkId::fromString($args['id']);
        $imageId = ImageId::generate();

        /** @var UploadedFile $image */
        $image = $request->getUploadedFiles()['image'];

        $filename = $imageId.'_'.$image->getClientFilename();
        $this->filesystem->writeStream("images/source/$filename", $image->getStream()->detach());

        $this->commandBus->handle(new AddImage($workId, $imageId, $filename, $image->getClientFilename()));

        return new RedirectResponse("/admin/works/$workId/images");
    }
}
