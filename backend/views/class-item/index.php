<?php

use kotchuprik\sortable\grid\Column;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Class Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="class-item-index">
    <div class="box box-info">
        <div class="box-body">
            <p>
                <?= Html::a('Create Class Item', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'rowOptions' => function ($dataProvider, $key, $index, $grid) {
                    return ['data-sortable-id' => $dataProvider->id];
                },

                'columns' => [
                    ['class' => Column::className(),],
                    'alias',
                    'title',
                    'status',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
                'options' => [
                    'data' => [
                        'sortable-widget' => 1,
                        'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
                    ]
                ],
            ]); ?>
        </div>
    </div>
</div>
