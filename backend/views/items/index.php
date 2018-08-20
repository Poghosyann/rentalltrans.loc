<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">
    <div class="box box-info">
        <div class="box-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'image',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){
                            return Html::img("/uploads/items/".$model->id.'/'.$model->images[0]->path,['width' => '70px']);
                        }
                    ],
                    'category.title',
                    'user.first_name',
                    'user.last_name',
                    'model.model',
                    //'class_id',
                    //'type_body_id',
                    //'transmission_vehicles_id',
                    //'year_manufacture',
                    //'quantity_doors',
                    //'steering_wheel',
                    //'description:ntext',
                    'price_daily',
                    //'price_3_days',
                    //'price_weekly',
                    'created',
                    //'updated',
                    'status',
                    [
                        'attribute' => 'status',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){
                            return $model->publish == 1? 'Active' : 'Inactive';
                        }
                    ],
                    'car_price',
                    //'country_id',
                    //'city_id',
                    //'deposit',
                    //'insurance',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
