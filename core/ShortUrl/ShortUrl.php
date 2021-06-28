<?php

declare(strict_types=1);

namespace Core\ShortUrl;

use Core\Common\Event\Events;
use Core\ShortUrl\Events\ShortUrlWasCreated;
use Core\ShortUrl\Props\NumberOfTransitions;
use Core\ShortUrl\Props\OriginalUrl;
use Core\ShortUrl\Props\ShortUrlId;

final class ShortUrl
{
    use Events;

    private ShortUrlId $id;
    private OriginalUrl $originalUrl;
    private NumberOfTransitions $numberOfTransitions;
    private \DateTimeImmutable $createdAt;

    public function __construct(ShortUrlId $id, OriginalUrl $originalUrl, NumberOfTransitions $numberOfTransitions)
    {
        $this->id = $id;
        $this->originalUrl = $originalUrl;
        $this->numberOfTransitions = $numberOfTransitions;
        $this->createdAt = new \DateTimeImmutable();

        $this->addEvent(new ShortUrlWasCreated($this->id, $originalUrl, $numberOfTransitions));
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

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
