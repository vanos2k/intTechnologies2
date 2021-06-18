<?php

namespace app\controllers\mysql;

use app\models\Car;
use app\models\Rent;
use Faker\Factory;
use yii\db\Expression;
use yii\web\Controller;

class RentController extends Controller
{
    public function actionGenerate()
    {
        $faker = Factory::create();
        $car = Car::find()->orderBy(new Expression('rand()'))->one();
        $rent = new Rent(
            [
                'car_id' => $car->id,
                'date_start' => $faker->date(),
                'date_end' => $faker->date(),
                'time_start' => $faker->time(),
                'time_end' => $faker->time(),
                'cost' => $faker->randomFloat(),
            ]
        );
        $rent->save();
        return $this->redirect(['mysql/index']);
    }
}
