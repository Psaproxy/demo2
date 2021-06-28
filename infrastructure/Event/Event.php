<?php

declare(strict_types=1);

namespace App\Infrastructure\Event;

use Core\Common\Event\Event as OriginalEvent;
use yii\base\Event as BaseEvent;

class Event extends BaseEvent
{
    private OriginalEvent $originalEvent;

    public function __construct(OriginalEvent $originalEvent, $config = [])
    {
        parent::__construct($config);
        $this->originalEvent = $originalEvent;
    }

    /**
     * @return OriginalEvent
     */
    public function originalEvent(): OriginalEvent
    {
        return $this->originalEvent;
    }
}
