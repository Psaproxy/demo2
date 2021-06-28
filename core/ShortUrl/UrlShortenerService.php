<?php

declare(strict_types=1);

namespace Core\ShortUrl;

use Core\Common\Event\Events;
use Core\ShortUrl\Events\ShortUrlTransitionWasUpdated;
use Core\ShortUrl\Props\NumberOfTransitions;
use Core\ShortUrl\Props\OriginalUrl;
use Core\ShortUrl\Props\ShortUrlId;

final class UrlShortenerService
{
    use Events;

    private IRepository $repository;
    private IDataProvider $dataProvider;

    public function __construct(IRepository $repository, IDataProvider $dataProvider)
    {
        $this->repository = $repository;
        $this->dataProvider = $dataProvider;
    }

    /**
     * @throws \Exception
     */
    public function add(OriginalUrl $originalUrl): ShortUrl
    {
        do {
            $id = new ShortUrlId();
            $isIdExists = $this->repository->has($id);
        } while (true === $isIdExists);

        $shortUrl = new ShortUrl($id, $originalUrl, new NumberOfTransitions(0));

        $this->repository->add($shortUrl);

        return $shortUrl;
    }

    /**
     * @throws \Exception
     */
    public function incTransition(ShortUrlId $id): void
    {
        $this->dataProvider->incTransition($id);

        $this->addEvent(new ShortUrlTransitionWasUpdated($id));
    }
}
