<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ClassItem */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Class Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="class-item-view">
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
                    'id',
                    'alias',
                    'title',
                    'order',
                    'status',
                ],
            ]) ?>
        </div>
    </div>
</div>
