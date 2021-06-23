<?php

namespace app\controllers\mongo;

use app\models\mongo\Car;
use app\models\mongo\Vendor;
use Faker\Factory;
use yii\web\Controller;

class CarController extends Controller
{
    public function actionGenerate()
    {
        $faker = Factory::create();
        $vendors = Vendor::find()->all();
        $vendor = $vendors[array_rand($vendors)];

        $car = new Car(
            [
                'name' => $faker->name,
                'release_date' => $faker->date(),
                'state' => array_rand(['new', 'old']),
                'race' => $faker->colorName,
                'vendor_id'=>$vendor->_id
            ]
        );

        $car->save();

        return $this->redirect(['mongo/index']);
    }
}
