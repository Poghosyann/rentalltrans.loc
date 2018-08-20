<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slider-form">
    <div class="box box-info">
        <div class="box-body">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
            <?= $form->field($model, 'image')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                ],
                'pluginOptions' => [
                    'uploadUrl' => false,
                    'maxFileCount' => 1,
                    'uploadExtraData' => [
                        'id' => $model->id,
                    ],
                    'initialPreview' => (!$model->isNewRecord && $model->image) ? Html::img("/uploads/sliders/$model->image", array('width' => '300px')) : '',
                    'allowedFileExtensions' =>  ['jpg', 'png','gif'],
                    'showUpload' => false,
                    'showRemove' => true,
                    'dropZoneEnabled' => true
                ]
            ]);?>

            <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'active')->checkbox() ?>


            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
