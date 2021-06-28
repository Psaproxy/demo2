<?php

declare(strict_types=1);

namespace Core\ShortUrl\Events;

use Core\Common\Event\Event;
use Core\ShortUrl\Props\ShortUrlId;

class ShortUrlTransitionWasUpdated extends Event
{
    private ShortUrlId $id;

    public function __construct(ShortUrlId $id)
    {
        parent::__construct();
        $this->id = $id;
    }

    public function id(): ShortUrlId
    {
        return $this->id;
    }
}
