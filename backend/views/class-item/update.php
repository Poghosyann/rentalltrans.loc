<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ClassItem */

$this->title = 'Update Class Item: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Class Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="class-item-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
