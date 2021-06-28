<?php

declare(strict_types=1);

namespace Core\Common\Event;

interface IEventsPublisher
{
    public function publish(Event ...$events): void;
}
