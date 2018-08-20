<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-view">
    <div class="box box-info">
        <div class="box-body">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id, 'category_id' => $model->category_id, 'user_id' => $model->user_id, 'country_id' => $model->country_id, 'city_id' => $model->city_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id, 'category_id' => $model->category_id, 'user_id' => $model->user_id, 'country_id' => $model->country_id, 'city_id' => $model->city_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'alias',
                    'category_id',
                    'user_id',
                    'model_id',
                    'mark_id',
                    'class_id',
                    'type_body_id',
                    'transmission_vehicles_id',
                    'year_manufacture',
                    'quantity_doors',
                    'steering_wheel',
                    'description:ntext',
                    'price_daily',
                    'price_3_days',
                    'price_weekly',
                    'created',
                    'updated',
                    'status',
                    'publish',
                    'deleted',
                    'country_id',
                    'city_id',
                    'deposit',
                    'insurance',
                ],
            ]) ?>
        </div>
    </div>
</div>
