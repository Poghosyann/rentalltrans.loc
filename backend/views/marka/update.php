<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Marka */

$this->title = 'Update Marka: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Markas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="marka-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
