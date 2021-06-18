<?php

namespace app\models\mongo;

use Yii;
use yii\mongodb\ActiveRecord;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $release_date
 * @property string|null $race
 * @property int|null $state
 * @property int|null $vendor_id
 */
class Car extends ActiveRecord
{
    public static function collectionName()
    {
        return 'car';
    }

    public function attributes()
    {
        return ['_id', 'release_date', 'state','name', 'race', 'vendor_id'];
    }

    public function getVendor()
    {
        return $this->hasOne(Vendor::class, ['_id' => 'vendor_id']);
    }
}
