<?php

namespace app\controllers\mongo;

use app\models\mongo\Car;
use app\models\mongo\Rent;
use Faker\Factory;
use yii\web\Controller;

class RentController extends Controller
{
    public function actionGenerate()
    {
        $faker = Factory::create();
        $cars = Car::find()->all();
        $car = $cars[array_rand($cars)];
        $rent = new Rent(
            [
                'car_id' => $car->_id,
                'date_start' => $faker->date(),
                'date_end' => $faker->date(),
                'time_start' => $faker->time(),
                'time_end' => $faker->time(),
                'cost' => $faker->randomFloat(),
            ]
        );
        $rent->save();
        return $this->redirect(['mongo/index']);
    }
}
