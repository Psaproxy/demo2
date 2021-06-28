<?php

declare(strict_types=1);

namespace Core\ShortUrl\Actions;

use Core\Common\Action\IDBTransaction;
use Core\Common\Action\TransactionalAction;
use Core\Common\Event\IEventsPublisher;
use Core\ShortUrl\Props\OriginalUrl;
use Core\ShortUrl\UrlShortenerService;

class Add extends TransactionalAction
{
    private IEventsPublisher $events;
    private UrlShortenerService $service;

    public function __construct(
        IDBTransaction $transaction,
        UrlShortenerService $service,
        IEventsPublisher $events,
    )
    {
        parent::__construct($transaction);
        $this->events = $events;
        $this->service = $service;
    }

    /**
     * @throws \Throwable
     */
    public function execute(string $originalUrl): string
    {
        return $this->transaction(function () use ($originalUrl) {
            $shortUrl = $this->service->add(new OriginalUrl($originalUrl));
            $this->events->publish(...$shortUrl->releaseEvents());

            return $shortUrl->id()->value();
        });
    }
}
