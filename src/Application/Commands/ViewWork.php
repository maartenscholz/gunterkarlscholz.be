<?php

declare(strict_types=1);

namespace Gks\Application\Commands;

final class ViewWork
{
    private string $workId;

    public function __construct(string $workId)
    {
        $this->workId = $workId;
    }

    public function workId(): string
    {
        return $this->workId;
    }
}
