<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">
    <div class="box box-info">
        <div class="box-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'icon')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                ],
                'pluginOptions' => [
                    'uploadUrl' => false,
                    'maxFileCount' => 1,
                    'uploadExtraData' => [
                        'id' => $model->id,
                    ],
                    'initialPreview' => (!$model->isNewRecord && $model->icon) ? Html::img("/uploads/categories/$model->icon", ['width' => 100]) : '',
                    'allowedFileExtensions' =>  ['jpg', 'png','gif'],
                    'showUpload' => false,
                    'showRemove' => true,
                    'dropZoneEnabled' => true
                ]
            ]);?>

            <?= $form->field($model, 'status')->checkbox() ?>
            <?= $form->field($model, 'add_item')->checkbox() ?>

            <div class="box box-default box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">META-TAGS</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: none;">
                    <div class="alert alert-info ">
                        <p>250 Maximum number of characters, the rest of the text will be cut.</p>
                    </div>
                    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
