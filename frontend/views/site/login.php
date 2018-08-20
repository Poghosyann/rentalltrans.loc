<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

$this->title = 'Log In';
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

                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>
                <div class="form-actions clearfix">
                    <div class="pull-left">
                        <?= $form->field($model, 'rememberMe', [
                            'inputTemplate' => '<label class="rememberme mt-checkbox mt-checkbox-outline">{input} Remember me<span></span></label>',
                        ])->textInput(['type' => 'checkbox'])->label(false);?>
                    </div>
                    <div class="pull-right forget-password-block">
                        <?= Html::a('Forgot Password?', ['/request-password-reset']) ?>.
                    </div>
                    <div class="login-options text-center">
                        Don’t have an account?  <?= Html::a('Sign Up', '/signup')?>
                    </div>
                </div>
                <div class="form-actions text-center">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-blue', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>