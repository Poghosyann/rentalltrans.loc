<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="container" id="header-contact">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="wow fadeInUp animated" style="color: #1a2226">Have questions, comments or concerns - we'd love to hear from you!</h2>
            </div>
        </div>
    </div>
<div class="site-contact">
    <div class="container">
        <div class="col-md-offset-1 col-md-10">
            <div class="row">
                <div class="col-md-7">
                    <?php $form = ActiveForm::begin([
                        'enableClientValidation'=> false,
                        'validateOnBlur'=>false,
                        'options' => [
                            'validationDelay'=> 1500,
                            'class' => 'form-signin'
                        ]]); ?>
                        <h5 class="form-signin-heading">Contact Us</h5>

                            <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => 'Your Name'])->label(false) ?>

                            <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Your Email'])->label(false) ?>

                            <?= $form->field($model, 'type')->dropDownList([
                                '' => 'Choose subject',
                                'Listing an Item' => 'Listing an Item',
                                'Renting an Item' => 'Renting an Item',
                                'My Account'=>'My Account',
                                'Refunds'=>'Refunds',
                                'Report Service Abuse'=>'Report Service Abuse',
                                'Site Feedback'=>'Site Feedback',
                            ], ['class' => 'js-states form-control'])->label(false);?>

                            <?= $form->field($model, 'message')->textarea(['placeholder' => 'Message', 'class' => 'form-control'])->label(false) ?>

                        <div class="form-actions text-right">
                            <?= Html::submitButton('Send Message', ['class' => 'btn btn-blue', 'name' => 'contact-button']) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="col-md-5">
                    <div class="contact-information">
                        <?if(!empty($page)):?>
                            <h5 class="form-signin-heading">Address</h5>
                            <?= $page->description?>
                        <?endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>