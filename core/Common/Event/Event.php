<?php

declare(strict_types=1);

namespace Core\Common\Event;

use DateTimeImmutable;

abstract class Event
{
    protected DateTimeImmutable $eventCreateAt;

    protected function __construct()
    {
        $this->eventCreateAt = new DateTimeImmutable();
    }

    public function eventCreatedAt(): DateTimeImmutable
    {
        return $this->eventCreateAt;
    }
}
