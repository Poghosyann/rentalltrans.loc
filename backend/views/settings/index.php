<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index">
    <div class="box box-info">
        <div class="box-body">

            <p>
                <? Html::a('Create Setting', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'name',
                    'value',

                    ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
                ],
            ]); ?>
        </div>
    </div>

</div>
