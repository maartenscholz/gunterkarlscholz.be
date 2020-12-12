<?php

declare(strict_types=1);

namespace Gks\Application\Handlers;

use Gks\Application\Commands\ViewWork as ViewWorkCommand;
use Gks\Application\DTOs\WorkDTO;
use Gks\Application\DTOs\WorkDTOTransformer;
use Gks\Domain\Model\Works\WorkId;
use Gks\Domain\Model\Works\WorkRepository;

final class ViewWork
{
    private WorkRepository $workRepository;

    public function __construct(WorkRepository $workRepository)
    {
        $this->workRepository = $workRepository;
    }

    public function handle(ViewWorkCommand $command): WorkDTO
    {
        $work = $this->workRepository->findById(WorkId::fromString($command->workId()));

        return (new WorkDTOTransformer())($work);
    }
}
