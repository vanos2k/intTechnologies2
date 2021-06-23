<?php

namespace app\models;

use Yii;

/**
 * @property int $id
 * @property int|null $car_id
 * @property string|null $date_start
 * @property string|null $time_start
 * @property string|null $date_end
 * @property string|null $time_end
 * @property float|null $cost
 */
class Rent extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'rent';
    }

    public function rules()
    {
        return [
            [['car_id'], 'integer'],
            [['date_start', 'time_start', 'date_end', 'time_end'], 'safe'],
            [['cost'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_id' => 'Car ID',
            'date_start' => 'Date Start',
            'time_start' => 'Time Start',
            'date_end' => 'Date End',
            'time_end' => 'Time End',
            'cost' => 'Cost',
        ];
    }
    
    public function getCar()
    {
        return $this->hasOne(Car::class, ['id' => 'car_id']);
    }
}
