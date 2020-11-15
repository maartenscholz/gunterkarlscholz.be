<?php

declare(strict_types=1);

namespace Gks\Application\DTOs;

final class WorkDTO
{
    public string $id;
    public string $slug;
    public string $type;
    public TitleDTO $title;
    public string $description;
    /** @var ImageDTO[] */
    public array $images = [];
}
