<?php

use yii\db\Migration;

class m210617_214731_create_cars_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%cars}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128),
            'release_date' => $this->date(),
            'race' => $this->string(128),
            'state' => $this->tinyInteger(),
            'vendor_id' => $this->integer()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%cars}}');
    }
}
