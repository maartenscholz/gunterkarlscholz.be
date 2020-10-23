<?php

declare(strict_types=1);

namespace Gks\Application\Handlers;

use Gks\Application\Commands\ViewWorks as ViewWorksCommand;
use Gks\Application\DTOs\WorkDTOTransformer;
use Gks\Infrastructure\Persistence\MySQL\WorkRepository;

final class ViewWorks
{
    private WorkRepository $workRepository;

    public function __construct(WorkRepository $workRepository)
    {
        $this->workRepository = $workRepository;
    }

    public function handle(ViewWorksCommand $command): array
    {
        $works = $this->workRepository->all();

        return array_map(new WorkDTOTransformer(), $works);
    }
}
