<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Sign Up';
Yii::$app->params['header_menu']  = false;
?>
<section id="signin-log">
    <div class="container">
        <div class="wrapper">
            <?php $form = ActiveForm::begin([
                'enableClientValidation'=> false,
                'validateOnBlur'=>false,
                'options' => [
                'class' => 'form-signin'
            ]]); ?>
                <h4 class="form-signin-heading"><?= Html::encode($this->title) ?></h4>
                <?= $form->field($model, 'first_name', [
                    'inputTemplate' => '{input}',
                ])->textInput(['autofocus' => '', 'placeholder' => 'First Name', 'class' => 'form-control'])->label(false);?>
                <?= $form->field($model, 'last_name', [
                    'inputTemplate' => '{input}',
                ])->textInput(['autofocus' => '', 'placeholder' => 'Last Name', 'class' => 'form-control'])->label(false);?>
                <?= $form->field($model, 'email', [
                    'inputTemplate' => '{input}',
                ])->textInput(['autofocus' => '', 'placeholder' => 'Email', 'class' => 'form-control'])->label(false);?>
                <?= $form->field($model, 'password', [
                    'inputTemplate' => '{input}',
                ])->passwordInput(['autofocus' => '', 'placeholder' => 'Password', 'class' => 'form-control'])->label(false);?>
                <?= $form->field($model, 'confirm_password', [
                    'inputTemplate' => '{input}',
                ])->passwordInput(['autofocus' => '', 'placeholder' => 'Confirm Password', 'class' => 'form-control'])->label(false);?>
                <?= $form->field($model, 'status')->hiddenInput()->label(false)?>
                <div class="form-actions text-center">
                    <p>By submitting, I agree to the <a href="/company/user-requirements" target="_blank"> User Requirements</a>, <a href="/company/site-terms" target="_blank">Site Terms</a> and <a href="/company/privacy-policy" target="_blank">Privacy Policy</a></p>
                </div>
                <div class="form-actions text-center">
                    <?= Html::submitButton('Sign up', ['class' => 'btn btn-blue', 'name' => 'signup-button']) ?>
                </div>

                <div class="login-options text-center">
                    Already have an account? <?= Html::a('Log In', '/login')?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>