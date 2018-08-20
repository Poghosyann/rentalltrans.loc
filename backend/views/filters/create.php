<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Filter */

$this->title = 'Create Filter';
$this->params['breadcrumbs'][] = ['label' => 'Filters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filter-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
