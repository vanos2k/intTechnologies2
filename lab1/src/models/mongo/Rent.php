<?php

namespace app\models\mongo;

use Yii;
use yii\mongodb\ActiveRecord;

/**
 * @property int $id
 * @property int|null $car_id
 * @property string|null $date_start
 * @property string|null $time_start
 * @property string|null $date_end
 * @property string|null $time_end
 * @property float|null $cost
 */
class Rent extends ActiveRecord
{
    public static function collectionName()
    {
        return 'rent';
    }

    public function attributes()
    {
        return ['_id', 'car_id', 'date_start', 'time_start', 'date_end', 'time_end', 'cost'];
    }

    public function getCar()
    {
        return $this->hasOne(Car::class, ['_id' => 'car_id']);
    }
}
