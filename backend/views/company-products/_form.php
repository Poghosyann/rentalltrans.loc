<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CompanyProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-product-form">
    <div class="box box-info">
        <div class="box-body">
            <div class="col-md-6">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model,'type')->dropdownlist(
                    [
                        1 => 'Additional insurance',
                        2 => 'Additional services',
                        3 => 'Delivery transport',
                    ]
                );?>

                <?= $form->field($model, 'description')->textarea()?>

                <?= $form->field($model, 'status')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
