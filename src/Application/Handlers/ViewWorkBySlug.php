<?php

declare(strict_types=1);

namespace Gks\Application\Handlers;

use Gks\Application\Commands\ViewWorkBySlug as ViewWorkBySlugCommand;
use Gks\Application\DTOs\WorkDTO;
use Gks\Application\DTOs\WorkDTOTransformer;
use Gks\Domain\Model\Works\WorkId;
use Gks\Domain\Model\Works\WorksRepository;

final class ViewWorkBySlug
{
    private WorksRepository $workRepository;

    public function __construct(WorksRepository $workRepository)
    {
        $this->workRepository = $workRepository;
    }

    public function handle(ViewWorkBySlugCommand $command): WorkDTO
    {
        $work = $this->workRepository->findBySlug($command->slug());

        return (new WorkDTOTransformer())($work);
    }
}
