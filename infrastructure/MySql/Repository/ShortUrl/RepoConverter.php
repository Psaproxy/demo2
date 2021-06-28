<?php

declare(strict_types=1);

namespace App\Infrastructure\MySql\Repository\ShortUrl;

use App\Infrastructure\MySql\ReflectionClass;
use app\models\ShortUrl as ShortUrlModel;
use Core\ShortUrl\Props\NumberOfTransitions;
use Core\ShortUrl\Props\OriginalUrl;
use Core\ShortUrl\Props\ShortUrlId;
use Core\ShortUrl\ShortUrl;

class RepoConverter
{

    public function toModel(ShortUrl $entity): ShortUrlModel
    {
        $model = new ShortUrlModel();
        $model->id = $entity->id()->value();
        $model->original_url = $entity->originalUrl()->value();
        $model->number_of_transitions = $entity->numberOfTransitions()->value();
        $model->setCreatedAt($entity->createdAt());

        return $model;
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function toEntity(ShortUrlModel $model): ShortUrl
    {
        /** @var ShortUrl $entity */
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $entity = ReflectionClass::newInstanceWithoutConstructor(
            ShortUrl::class,
            [
                'id' => new ShortUrlId($model->id),
                'original_url' => new OriginalUrl($model->original_url),
                'number_of_transitions' => new NumberOfTransitions($model->number_of_transitions),
                'created_at' => $model->createdAt(),
            ]
        );

        return $entity;
    }
}
