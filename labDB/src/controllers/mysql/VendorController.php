<?php

namespace app\controllers\mysql;

use app\models\Vendor;
use Faker\Factory;
use yii\web\Controller;

class VendorController extends Controller
{
    public function actionGenerate()
    {
        $faker = Factory::create();

        $vendor = new Vendor([
            'name' => $faker->userName
        ]);

        $vendor->save();

        return $this->redirect(['mysql/index']);
    }
}
