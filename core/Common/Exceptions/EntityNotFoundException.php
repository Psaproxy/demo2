<?php

declare(strict_types=1);

namespace Core\Common\Exceptions;

use Throwable;

class EntityNotFoundException extends \RuntimeException
{
    public function __construct(string $entityId, $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Не удалось найти сущность по ID "%s"', $entityId),
            $code,
            $previous
        );
    }
}
