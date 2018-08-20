<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Forgot Password';
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
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false) ?>
                </div>
                <div class="form-actions text-center">
                    <?= Html::submitButton('Request Reset Link', ['class' => 'btn btn-blue']) ?>
                </div>
                <div class="login-options text-center">
                    <?= Html::a('Back to Log In', '/login')?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>