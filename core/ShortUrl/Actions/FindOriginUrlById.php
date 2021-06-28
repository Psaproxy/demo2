<?php

declare(strict_types=1);

namespace Core\ShortUrl\Actions;

use Core\ShortUrl\IDataProvider;
use Core\ShortUrl\Props\ShortUrlId;

class FindOriginUrlById
{
    private IDataProvider $dataProvider;

    public function __construct(IDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * @throws \Exception
     */
    public function execute(string $id): ?string
    {
        $originalUrl = $this->dataProvider->findOriginalUrlById(new ShortUrlId($id));

        return null === $originalUrl ? null : $originalUrl->value();
    }
}
