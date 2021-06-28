<?php

declare(strict_types=1);

namespace Core\ShortUrl;

use Core\ShortUrl\Props\ShortUrlId;

interface IRepository
{
    public function get(ShortUrlId $id): ShortUrl;

    public function find(ShortUrlId $id): ?ShortUrl;

    public function has(ShortUrlId $id): bool;

    public function add(ShortUrl $shortUrl): void;
}
