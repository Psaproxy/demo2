<?php

declare(strict_types=1);

namespace Core\ShortUrl;

use Core\ShortUrl\Props\OriginalUrl;
use Core\ShortUrl\Props\ShortUrlId;

interface IDataProvider
{
    public function findIdByOriginalUrl(OriginalUrl $originalUrl): ?ShortUrlId;

    public function findOriginalUrlById(ShortUrlId $id): ?OriginalUrl;

    public function incTransition(ShortUrlId $id): void;
}
