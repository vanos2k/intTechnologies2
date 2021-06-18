<?php

namespace app\controllers\mysql;

use app\models\Car;
use app\models\Vendor;
use Faker\Factory;
use yii\db\Expression;
use yii\web\Controller;

class CarController extends Controller
{
    public function actionGenerate()
    {
        $faker = Factory::create();
        $vendor = Vendor::find()->orderBy(new Expression('rand()'))->one();
        $car = new Car(
            [
                'name' => $faker->name,
                'release_date' => $faker->date(),
                'state' => array_rand(['new', 'old']),
                'vendor_id' => $vendor->id,
                'race' => $faker->colorName,
            ]
        );
        $car->save();

        return $this->redirect(['mysql/index']);
    }
}
