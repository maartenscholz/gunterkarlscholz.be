<?php

namespace Gks\Infrastructure\Events\BigName;

use BigName\EventDispatcher\Event;

trait HasEvents
{
    private array $events = [];

    protected function recordEvent(Event $event): void
    {
        $this->events[] = $event;
    }

    public function releaseEvents(): array
    {
        $events = $this->events;

        $this->events = [];

        return $events;
    }
}
