<?php

declare(strict_types=1);

namespace Gks\Application\DTOs;

use Gks\Domain\Model\Work;

final class WorkDTOTransformer
{
    public function __invoke(Work $work): WorkDTO
    {
        $dto = new WorkDTO();

        $dto->id = $work->getId()->getValue()->toString();
        $dto->type = $work->getType()->getValue();
        $dto->title = $work->getTitle()->getValue('nl_BE');

        foreach ($work->getImages() as $image) {
            $imageDTO = new ImageDTO();

            $imageDTO->id = $image->getId()->getValue()->toString();
            $imageDTO->filename = $image->getFilename();
            $imageDTO->path = $image->getPath();

            $dto->images[] = $imageDTO;
        }

        return $dto;
    }
}
