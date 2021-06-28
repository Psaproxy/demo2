<?php

declare(strict_types=1);

namespace Core\Common\Entity;

class Text
{
    protected string $value;

    public function __construct(string $value = '')
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function equals(Text $text): bool
    {
        return $this->value() === $text->value();
    }

    public function isEmpty(): bool
    {
        return empty($this->value());
    }
}
