<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

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
    public static function tableName()
    {
        return 'cars';
    }

    public function rules()
    {
        return [
            [['release_date'], 'safe'],
            [['state', 'vendor_id'], 'integer'],
            [['name', 'race'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'release_date' => 'Release Date',
            'race' => 'Race',
            'state' => 'State',
            'vendor_id' => 'Vendor ID',
        ];
    }

    public function getVendor()
    {
        return $this->hasOne(Vendor::class, ['id' => 'vendor_id']);
    }
}
