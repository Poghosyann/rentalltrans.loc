<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TypeBody */

$this->title = 'Update Type Body: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Type Bodies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="type-body-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
