<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">
    <div class="box box-info">
        <div class="box-body">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
                    [
                        'attribute' => 'image',
                        'format'=>'raw',
                        'value' => Html::img("/uploads/categories/".$model->icon, ['width' => 250]),
                    ],
                    'id',
                    'alias',
                    'title',
                    'icon',
                    'meta_title',
                    'meta_keywords',
                    'meta_description:ntext',
                    'order',
                    'created',
                    'updated',
                    'status',
                ],
            ]) ?>
        </div>
    </div>
</div>
