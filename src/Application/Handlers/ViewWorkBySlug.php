<?php

declare(strict_types=1);

namespace Gks\Application\Handlers;

use Gks\Application\Commands\ViewWorkBySlug as ViewWorkBySlugCommand;
use Gks\Application\DTOs\WorkDTO;
use Gks\Application\DTOs\WorkDTOTransformer;
use Gks\Domain\Model\Works\WorkRepository;

final class ViewWorkBySlug
{
    private WorkRepository $workRepository;

    public function __construct(WorkRepository $workRepository)
    {
        $this->workRepository = $workRepository;
    }

    public function handle(ViewWorkBySlugCommand $command): WorkDTO
    {
        $work = $this->workRepository->findBySlug($command->slug());

        return (new WorkDTOTransformer())($work);
    }
}
