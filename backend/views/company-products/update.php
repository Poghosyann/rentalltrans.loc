<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CompanyProduct */

$this->title = 'Update Company Product: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Company Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="company-product-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
