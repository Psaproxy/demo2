<?php

declare(strict_types=1);

namespace App\Infrastructure\Core\ShortUrl\MySql;

use app\models\ShortUrl as ShortUrlModel;
use Core\Common\Exceptions\EntityNotFoundException;
use Core\ShortUrl\IRepository;
use Core\ShortUrl\Props\ShortUrlId;
use Core\ShortUrl\ShortUrl;

class Repository implements IRepository
{
    private RepoConverter $converter;

    public function __construct(RepoConverter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @throws \ReflectionException
     */
    public function get(ShortUrlId $id): ShortUrl
    {
        $model = $this->find($id);

        if (null === $model) {
            throw new EntityNotFoundException($id->value());
        }

        return $model;
    }

    /**
     * @throws \ReflectionException
     */
    public function find(ShortUrlId $id): ?ShortUrl
    {
        $model = ShortUrlModel::find()->where(['id' => $id->value()])->one();

        /** @noinspection PhpParamsInspection */
        return null === $model ? null : $this->converter->toEntity($model);
    }

    /**
     * @throws \yii\db\Exception
     */
    public function has(ShortUrlId $id): bool
    {
        return (bool)\Yii::$app->db
            ->createCommand('select id from short_urls where id = :id limit 1')
            ->bindValue(':id', $id->value())
            ->queryScalar();
    }

    /**
     * @throws \Throwable
     */
    public function add(ShortUrl $shortUrl): void
    {
        $model = $this->converter->toModel($shortUrl);
        $model->save();
    }
}
