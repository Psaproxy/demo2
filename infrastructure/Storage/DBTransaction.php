<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage;

use Core\Common\Action\IDBTransaction;
use Yii;

class DBTransaction implements IDBTransaction
{
    private ?\yii\db\Transaction $transaction;

    public function beginTransaction(): void
    {
        $this->transaction = Yii::$app->db->beginTransaction();
    }

    public function rollBack(): void
    {
        $this->transaction->rollBack();
    }

    /**
     * @throws \yii\db\Exception
     */
    public function commit(): void
    {
        $this->transaction->commit();
    }
}
