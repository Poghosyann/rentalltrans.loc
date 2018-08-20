<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = 'Update Item: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'category_id' => $model->category_id, 'user_id' => $model->user_id, 'country_id' => $model->country_id, 'city_id' => $model->city_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="item-update">

    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries,
        'cities' => $cities,
        'item_class' => $item_class,
        'marka' => $marka,
        'year' => $year,
        'transmission_vehicles' => $transmission_vehicles,
        'type_body' => $type_body,
    ]) ?>

</div>
