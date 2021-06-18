<?php

use yii\db\Migration;

class m210617_215138_create_rent_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%rent}}', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer(),
            'date_start' => $this->date(),
            'time_start' => $this->time(),
            'date_end' => $this->date(),
            'time_end' => $this->time(),
            'cost' => $this->float()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%rent}}');
    }
}
