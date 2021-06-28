<?php

use yii\db\Migration;

class m210628_142902_CreateShortUrlsTable extends Migration
{
    public function safeUp():void
    {
        $this->createTable('short_urls', [
            'id' => $this->string(16)->notNull(),
            'original_url' => $this->string(2000)->notNull()->unique(),
            'number_of_transitions' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
        ]);
        $this->addPrimaryKey('short_urls_pk', 'short_urls', ['id']);
    }

    public function safeDown():void
    {
        $this->dropTable('short_urls');
    }
}
