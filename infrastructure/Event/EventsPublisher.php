<?php

declare(strict_types=1);

namespace App\Infrastructure\Event;

use Core\Common\Event\Event as OriginalEvent;
use Core\Common\Event\IEventsPublisher;
use yii\base\Component;

class EventsPublisher extends Component implements IEventsPublisher
{
    public function publish(OriginalEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->trigger($event::class, new Event($event));
        }
    }
}
