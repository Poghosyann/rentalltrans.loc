<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TransmissionVehicles */

$this->title = 'Create Transmission Vehicles';
$this->params['breadcrumbs'][] = ['label' => 'Transmission Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transmission-vehicles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
