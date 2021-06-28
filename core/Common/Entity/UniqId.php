<?php

declare(strict_types=1);

namespace Core\Common\Entity;

use Core\Common\Exceptions\InvalidArgumentException;
use Ramsey\Uuid\UuidFactory;

class UniqId
{
    private string $id;

    public function __construct(string $id = null)
    {
        try {
            $factory = new UuidFactory();

            $this->id = null === $id
                ? $factory->uuid4()->toString()
                : $id;

        } catch (\InvalidArgumentException) {
            throw new InvalidArgumentException('Неверное значение UUID.');
        }
    }

    public function value(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function equals(UniqId $comparableId): bool
    {
        return $this->value() === $comparableId->value();
    }
}
