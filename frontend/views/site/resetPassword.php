<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'New Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="signin-log">
    <div class="container">
        <div class="wrapper">
            <?php $form = ActiveForm::begin([
                'validateOnBlur'=>false,
                'options' => [
                    'class' => 'form-signin'
                ]]); ?>

                <h4 class="form-signin-heading"><?= Html::encode($this->title) ?></h4>
                <div class="form-group">
                    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => 'New Password'])->label(false) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'confirm_password')->passwordInput(['autofocus' => true, 'placeholder' => 'Confirm Password'])->label(false) ?>
                </div>
                <div class="form-actions text-center">
                    <?= Html::submitButton('Save Password', ['class' => 'btn btn-blue']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>