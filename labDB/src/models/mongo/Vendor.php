<?php

namespace app\models\mongo;

use Yii;
use yii\mongodb\ActiveRecord;

/**
 * @property int $id
 * @property string|null $name
 */
class Vendor extends ActiveRecord
{
    public static function collectionName()
    {
        return 'vendor';
    }

    public function attributes()
    {
        return ['_id', 'name'];
    }
}
