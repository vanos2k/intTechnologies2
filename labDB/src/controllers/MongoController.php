<?php

namespace app\controllers;

use app\models\mongo\Car;
use app\models\mongo\Rent;
use app\models\mongo\Vendor;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class MongoController extends Controller
{
    public function actionIndex()
    {
        $vendorDataProvider = new ActiveDataProvider(
            [
                'query' => Vendor::find(),
                'pagination' => [
                    'pageSize' => 5,
                    'pageParam' => 'v-page',
                    'pageSizeParam' => 'v-per-page',
                ],
            ]
        );
        $carDataProvider = new ActiveDataProvider(
            [
                'query' => Car::find(),
                'pagination' => [
                    'pageSize' => 5,
                    'pageParam' => 'c-page',
                    'pageSizeParam' => 'c-per-page',
                ],
            ]
        );
        $rentDataProvider = new ActiveDataProvider(
            [
                'query' => Rent::find(),
                'pagination' => [
                    'pageSize' => 10,
                    'pageParam' => 'r-page',
                    'pageSizeParam' => 'r-per-page',
                ],
            ]
        );

        return $this->render(
            'index',
            [
                'vendorDataProvider' => $vendorDataProvider,
                'carDataProvider' => $carDataProvider,
                'rentDataProvider' => $rentDataProvider
            ]
        );
    }
}
