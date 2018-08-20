<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = 'Add My Item';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="user-page">
    <section class="container">
        <div class="portlet-header clearfix">
            <div class="caption hidden-xs hidden-sm">
                <ol class="breadcrumb">

                </ol>
            </div>
        </div>
        <?= $this->render('_form', [
            'model' => $model,
            'title' => $this->title,
            'countries' => $countries,
            'cities' => $cities,
            'item_class' => $item_class,
            'marka' => $marka,
            'year' => $year,
            'transmission_vehicles' => $transmission_vehicles,
            'type_body' => $type_body,
        ]) ?>

    </section>
</section>