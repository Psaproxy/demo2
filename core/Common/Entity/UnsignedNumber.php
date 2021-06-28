<?php

declare(strict_types=1);

namespace Core\Common\Entity;

use Core\Common\Exceptions\InvalidArgumentException;

class UnsignedNumber
{
    protected int $value;

    public function __construct(int $value = 0)
    {
        if (0 > $value) {
            throw new InvalidArgumentException('Число должно быть равно 0 или более.');
        }

        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }

    public function equals(Number $text): bool
    {
        return $this->value() === $text->value();
    }

    public function isEmpty(): bool
    {
        return empty($this->value());
    }
}
