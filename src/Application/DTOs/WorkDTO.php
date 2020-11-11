<?php

declare(strict_types=1);

namespace Gks\Application\DTOs;

final class WorkDTO
{
    public string $id;
    public string $type;
    public TitleDTO $title;
    /** @var ImageDTO[] */
    public array $images = [];
}
