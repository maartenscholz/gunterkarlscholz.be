<?php

declare(strict_types=1);

namespace Gks\Application\Commands;

final class ViewWorkBySlug
{
    private string $slug;

    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    public function slug(): string
    {
        return $this->slug;
    }
}
