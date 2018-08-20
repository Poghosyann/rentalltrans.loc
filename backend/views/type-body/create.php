<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TypeBody */

$this->title = 'Create Type Body';
$this->params['breadcrumbs'][] = ['label' => 'Type Bodies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-body-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
