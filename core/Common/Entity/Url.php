<?php

declare(strict_types=1);

namespace Core\Common\Entity;

use Core\Common\Exceptions\InvalidArgumentException;

class Url extends Text
{
    public function __construct(string $value)
    {
        $value = trim($value);

        if ('' === $value) {
            throw new InvalidArgumentException('URL-адрес не может быть пустой строкой.');
        }

        if (2000 < \mb_strlen($value)) {
            throw new InvalidArgumentException('URL-адрес не должно быть длиннее 2000 знаков.');
        }

        parent::__construct($value);
    }
}
