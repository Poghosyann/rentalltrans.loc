<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ClassItem */

$this->title = 'Create Class Item';
$this->params['breadcrumbs'][] = ['label' => 'Class Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="class-item-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
