<?php

namespace app\controllers\mongo;

use app\models\mongo\Vendor;
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

        return $this->redirect(['mongo/index']);
    }
}
