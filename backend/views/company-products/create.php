<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CompanyProduct */

$this->title = 'Create Company Product';
$this->params['breadcrumbs'][] = ['label' => 'Company Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
