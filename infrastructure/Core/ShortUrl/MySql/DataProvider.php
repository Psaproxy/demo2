<?php

declare(strict_types=1);

namespace App\Infrastructure\Core\ShortUrl\MySql;

use Core\ShortUrl\IDataProvider;
use Core\ShortUrl\Props\OriginalUrl;
use Core\ShortUrl\Props\ShortUrlId;

class DataProvider implements IDataProvider
{
    /**
     * @throws \yii\db\Exception
     * @throws \Exception
     */
    public function findIdByOriginalUrl(OriginalUrl $originalUrl): ?ShortUrlId
    {
        $id = \Yii::$app->db
            ->createCommand('select id from short_urls where original_url = :original_url limit 1')
            ->bindValue(':original_url', $originalUrl->value())
            ->queryScalar();

        return false === $id ? null : new ShortUrlId($id);
    }

    /**
     * @throws \yii\db\Exception
     * @throws \Exception
     */
    public function findOriginalUrlById(ShortUrlId $id): ?OriginalUrl
    {
        $original_url = \Yii::$app->db
            ->createCommand('select original_url from short_urls where id = :id limit 1')
            ->bindValue(':id', $id->value())
            ->queryScalar();

        return false === $original_url ? null : new OriginalUrl($original_url);
    }

    /**
     * @throws \yii\db\Exception
     * @throws \Exception
     */
    public function incTransition(ShortUrlId $id): void
    {
        \Yii::$app->db
            ->createCommand('update short_urls set number_of_transitions = 1 + number_of_transitions where id = :id limit 1')
            ->bindValue(':id', $id->value())
            ->execute();
    }
}
