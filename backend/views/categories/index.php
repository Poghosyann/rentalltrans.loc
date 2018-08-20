<?php

use kotchuprik\sortable\grid\Column;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <div class="box box-info">
        <div class="box-body">

            <p>
                <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
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
                            return Html::img("/uploads/categories/".$model->icon,['width' => '70px']);
                        }
                    ],
                    'alias',
                    'title',
                    [
                        'attribute' => 'status',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){
                            return $model->status == 1? 'Active' : 'Inactive';
                        }
                    ],
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
