<?php

use kotchuprik\sortable\grid\Column;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sliders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-index">
    <div class="box box-info">
        <div class="box-body">
            <p>
                <?= Html::a('Create Slider', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'rowOptions' => function ($dataProvider, $key, $index, $grid) {
                    return ['data-sortable-id' => $dataProvider->id];
                },

                'columns' => [
                    ['class' => Column::className(),],
                    [
                        'attribute' => 'image',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){
                            return Html::img("/uploads/sliders/400-200/".$model->image,['width' => '70px']);
                        }
                    ],
                    'text:ntext',
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
