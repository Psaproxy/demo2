<?php

declare(strict_types=1);

namespace Core\ShortUrl\View;

class ShortUrlDTO
{
    public string $id;
    public string $originalUrl;
    public int $numberOfTransitions;

    public function __construct(string $id, string $originalUrl, int $numberOfTransitions)
    {
        $this->id = $id;
        $this->originalUrl = $originalUrl;
        $this->numberOfTransitions = $numberOfTransitions;
    }
}