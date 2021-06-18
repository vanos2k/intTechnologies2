<?php


/**
 * @var ActiveDataProvider $vendorDataProvider
 * @var ActiveDataProvider $carDataProvider
 * @var ActiveDataProvider $rentDataProvider
 */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<?=Html::a('Use MySQL driver',['mysql/index'],['class'=>'btn btn-default'])?>
<div class="btn btn-primary">Use Mongo driver</div>

<div class="row">
    <div class="col-md-6">
        <?php Pjax::begin(['id' => 'vendor_container']) ?>

        <h2>
            <em>Vendors</em>
            <?= Html::a('Generate random', ['mongo/vendor/generate'], ['class' => 'btn btn-link pull-right', 'data-pjax' => true]) ?>
        </h2>
        <?= GridView::widget(
            [
                'dataProvider' => $vendorDataProvider,
                'columns' => [
                    'name'
                ]
            ]
        )
        ?>
        <?php Pjax::end() ?>
    </div>
    <div class="col-md-6">
        <?php Pjax::begin(['id' => 'car_container']) ?>

        <h2>
            <em>Cars</em>
            <?= Html::a('Generate random', ['mongo/car/generate'], ['class' => 'btn btn-link pull-right', 'data-pjax' => true]) ?>
        </h2>
        <?= GridView::widget(
            [
                'dataProvider' => $carDataProvider,
                'columns' => [
                    'name',
                    'release_date:date',
                    'race',
                    'state',
                    'vendor.name'
                ]
            ]
        )
        ?>
        <?php Pjax::end() ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php Pjax::begin(['id' => 'rent_container']) ?>

        <h2>
            <em>Rent</em>
            <?= Html::a('Generate random', ['mongo/rent/generate'], ['class' => 'btn btn-link pull-right', 'data-pjax' => true]) ?>
        </h2>
        <?= GridView::widget(
            [
                'dataProvider' => $rentDataProvider,
                'columns' => [
                    'car.name',
                    'date_start:date',
                    'time_start:time',
                    'date_end:date',
                    'time_end:time',
                    'cost:currency',
                ]
            ]
        )
        ?>

        <?php Pjax::end() ?>
    </div>
</div>

