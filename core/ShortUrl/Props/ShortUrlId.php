<?php

declare(strict_types=1);

namespace Core\ShortUrl\Props;

final class ShortUrlId
{
    private string $id;

    /**
     * @throws \Exception
     */
    public function __construct(string $id = null)
    {
        $this->id = null === $id
            ? bin2hex(random_bytes(8))
            : $id;
    }

    public function value(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function equals(ShortUrlId $comparableId): bool
    {
        return $this->value() === $comparableId->value();
    }
}
