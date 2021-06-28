<?php

declare(strict_types=1);

namespace Core\Common\Event;

trait Events
{
    /**
     * @var array<Event>
     */
    private array $events = [];

    private function addEvent(Event $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return array<Event>
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
