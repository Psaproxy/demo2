<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property string $id
 * @property string $original_url
 * @property int $number_of_transitions
 * @property \DateTimeImmutable $created_at
 */
class ShortUrl extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'short_urls';
    }

    /**
     * @throws \Exception
     */
    public function createdAt(): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->created_at);
    }

    public function setCreatedAt(\DateTimeImmutable $value): void
    {
        $this->created_at = $value->format('Y-m-d H:i:s');
    }
}
