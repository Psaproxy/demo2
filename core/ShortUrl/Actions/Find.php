<?php

declare(strict_types=1);

namespace Core\ShortUrl\Actions;

use Core\ShortUrl\IRepository;
use Core\ShortUrl\Props\ShortUrlId;
use Core\ShortUrl\View\ShortUrlDTO;

class Find
{
    private IRepository $repository;

    public function __construct(IRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws \Exception
     */
    public function execute(string $id): ?ShortUrlDTO
    {
        $shortUrl = $this->repository->get(new ShortUrlId($id));

        return null === $shortUrl ? null : new ShortUrlDTO(
            $shortUrl->id()->value(),
            $shortUrl->originalUrl()->value(),
            $shortUrl->numberOfTransitions()->value(),
        );
    }
}
