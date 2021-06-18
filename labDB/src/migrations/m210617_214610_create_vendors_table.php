<?php

use yii\db\Migration;

class m210617_214610_create_vendors_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%vendors}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%vendors}}');
    }
}
