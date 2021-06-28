<?php

declare(strict_types=1);

namespace Core\ShortUrl\Actions;

use Core\ShortUrl\IDataProvider;
use Core\ShortUrl\Props\OriginalUrl;

class FindId
{
    private IDataProvider $dataProvider;

    public function __construct(IDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    public function execute(string $originalUrl): ?string
    {
        $id = $this->dataProvider->findIdByOriginalUrl(new OriginalUrl($originalUrl));

        return null === $id ? null : $id->value();
    }
}
