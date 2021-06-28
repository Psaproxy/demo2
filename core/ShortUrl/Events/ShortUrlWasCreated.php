<?php

declare(strict_types=1);

namespace Core\ShortUrl\Events;

use Core\Common\Event\Event;
use Core\ShortUrl\Props\NumberOfTransitions;
use Core\ShortUrl\Props\OriginalUrl;
use Core\ShortUrl\Props\ShortUrlId;

class ShortUrlWasCreated extends Event
{
    private ShortUrlId $id;
    private OriginalUrl $originalUrl;
    private NumberOfTransitions $numberOfTransitions;

    public function __construct(ShortUrlId $id, OriginalUrl $originalUrl, NumberOfTransitions $numberOfTransitions)
    {
        parent::__construct();
        $this->id = $id;
        $this->originalUrl = $originalUrl;
        $this->numberOfTransitions = $numberOfTransitions;
    }

    public function id(): ShortUrlId
    {
        return $this->id;
    }

    public function originalUrl(): OriginalUrl
    {
        return $this->originalUrl;
    }

    public function numberOfTransitions(): NumberOfTransitions
    {
        return $this->numberOfTransitions;
    }
}
