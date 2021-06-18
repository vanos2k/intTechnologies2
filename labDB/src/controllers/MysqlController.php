<?php

namespace app\controllers;

use app\models\Car;
use app\models\Rent;
use app\models\Vendor;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class MysqlController extends Controller
{
    public function actionIndex()
    {
        $vendorDataProvider = new ActiveDataProvider(
            [
                'query' => Vendor::find(),
                'pagination' => [
                    'pageSize' => 5,
                    'pageParam'=>'v-page',
                    'pageSizeParam'=>'v-per-page',
                ],
            ]
        );
        $carDataProvider = new ActiveDataProvider(
            [
                'query' => Car::find(),
                'pagination' => [
                    'pageSize' => 5,
                    'pageParam'=>'c-page',
                    'pageSizeParam'=>'c-per-page',
                ],
            ]
        );
        $rentDataProvider = new ActiveDataProvider(
            [
                'query' => Rent::find(),
                'pagination' => [
                    'pageSize' => 10,
                    'pageParam'=>'r-page',
                    'pageSizeParam'=>'r-per-page',
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
