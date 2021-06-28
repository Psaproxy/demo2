<?php

declare(strict_types=1);

namespace Core\ShortUrl\Actions;

use Core\Common\Action\IDBTransaction;
use Core\Common\Action\TransactionalAction;
use Core\Common\Event\IEventsPublisher;
use Core\ShortUrl\Props\ShortUrlId;
use Core\ShortUrl\UrlShortenerService;

class IncTransition extends TransactionalAction
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
        $this->service = $service;
        $this->events = $events;
    }

    /**
     * @throws \Throwable
     */
    public function execute(string $id): void
    {
        $this->transaction(function () use ($id) {
            $this->service->incTransition(new ShortUrlId($id));
            $this->events->publish(...$this->service->releaseEvents());
        });
    }
}
