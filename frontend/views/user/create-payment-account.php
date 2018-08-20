<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 4/28/2017
 * Time: 3:04 PM
 */

use common\widgets\Alert;
use frontend\widgets\LeftInfo;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Create Payment Account';
?>

<section id="user-page">
    <div class="container">
        <div class="portlet-header clearfix">
            <div class="caption hidden-xs hidden-sm">
                <ol class="breadcrumb">

                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                <?= LeftInfo::widget()?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 clearfix">
                <div class="portlet-form paymentaccount">
                    <div class="caption-title">
                        <h4>Create Payment Account</h4>
                    </div>
                    <?php $form = ActiveForm::begin(['validateOnBlur'=>false]) ?>
                        <div class="caption-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <?= Alert::widget()?>
                                    <p>
                                        rentalltrans.com has partnered with ProPay (a TSYS Company), a registered ISO of Wells Fargo Bank, for Merchant Services to ensure that your rental or purchase transaction fees are safe & secure and arrive on-time. To start earning now, please complete all requested payment information.
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <img src="/images/logo_trans_green.png" alt="log">
                                </div>
                            </div>
                            <div class="caption-title sub-caption">
                                <h4>Personal Information</h4>
                            </div>
                        </div>
                        <div class="caption-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <?= $form->field($model, 'email', [
                                            'template' => '<label class="">Email <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([ 'class' => 'form-control', 'value' => $user_model->email])->label(false);?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'first_name', [
                                            'template' => '<label class="">First Name <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([ 'class' => 'form-control', 'value' => $user_model->first_name])->label(false);?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'last_name', [
                                            'template' => '<label class="">Last Name <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([ 'class' => 'form-control', 'value' => $user_model->last_name])->label(false);?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'address_line_1', [
                                            'template' => '<label class="">Address Line 1 <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([ 'class' => 'form-control', 'value' => $user_model->address_line_1])->label(false);?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'address_line_2', [
                                            'template' => '<label class="">Address Line 2 </label>{input}',
                                        ])->textInput([ 'class' => 'form-control', 'value' => $user_model->address_line_2])->label(false);?>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">State <span class="required" aria-required="true"> * </span></label>
                                                    <?= $form->field($model, 'state')
                                                        ->dropDownList($state , ['class' => 'js-states form-control','prompt'=>'State'])
                                                        ->label(false);
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'phone_1', [
                                            'template' => '<label class="">Phone 1 (day phone) <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([
                                            'class' => 'form-control',
                                            'value' => preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $model->phone_1)
                                        ])->label(false);?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'phone_2', [
                                            'template' => '<label class="">Phone 2 (evening phone) <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([
                                            'class' => 'form-control',
                                            'value' => preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $model->phone_2)
                                        ])->label(false);?>
                                    </div>

                                    <div class="form-group date-of-birth">
                                        <label class="control-label">Date Of Birth <span class="required" aria-required="true"> * </span></label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?= $form->field($model, 'month')->dropDownList([
                                                            '01' => 'Jan',
                                                            '02' => 'Feb',
                                                            '03' => 'Mar',
                                                            '04' => 'Apr',
                                                            '05' => 'May',
                                                            '06' => 'Jun',
                                                            '07' => 'Jul',
                                                            '08' => 'Aug',
                                                            '09' => 'Sep',
                                                            '10' => 'Oct',
                                                            '11' => 'Nov',
                                                            '12' => 'Dec',
                                                        ],
                                                        [
                                                            'class' => 'js-states form-control',
                                                            'prompt'=>'Month'
                                                        ])->label(false);?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?= $form->field($model, 'dey')->dropDownList([
                                                        '01' => '01',
                                                        '02' => '02',
                                                        '03' => '03',
                                                        '04' => '04',
                                                        '05' => '05',
                                                        '06' => '06',
                                                        '07' => '07',
                                                        '08' => '08',
                                                        '09' => '09',
                                                        '10' => '10',
                                                        '11' => '11',
                                                        '12' => '12',
                                                        '13' => '13',
                                                        '14' => '14',
                                                        '15' => '15',
                                                        '16' => '16',
                                                        '17' => '17',
                                                        '18' => '18',
                                                        '19' => '19',
                                                        '20' => '20',
                                                        '21' => '21',
                                                        '22' => '22',
                                                        '23' => '23',
                                                        '24' => '24',
                                                        '25' => '25',
                                                        '26' => '26',
                                                        '27' => '27',
                                                        '28' => '28',
                                                        '29' => '29',
                                                        '30' => '30',
                                                        '31' => '31',
                                                    ], ['class' => 'js-states form-control', 'prompt'=>'Day'])->label(false);?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?= $form->field($model, 'year')->dropDownList($year, ['class' => 'js-states form-control', 'prompt'=>'Year'])->label(false);?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'ssn', [
                                            'template' => '<label class="control-label">Tax Identification Number (SSN or EIN) <span class="required" aria-required="true"> * </span> <a href="/company/tax-identification-number" data-toggle="tooltip" target="_blank"><i class="fa fa-question-circle"></i></a></label>{input}',
                                        ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                    </div>
                                </div>
                            </div>
                            <div class="caption-title sub-caption">
                                <h4>Bank Account Information</h4>
                            </div>
                        </div>
                        <div class="caption-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <?= $form->field($model, 'bank_account_name', [
                                            'template' => '<label class="">Bank Account Name (e.g. John Smith) <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'bank_account_number', [
                                            'template' => '<label class="">Bank Account Number <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'bank_name', [
                                            'template' => '<label class="">Bank Name (e.g. Wells Fargo) <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'routing_number', [
                                            'template' => '<label class="">Bank Routing Number <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                    </div>
                                    <p class="caption-terms">
                                        <?
                                        $model->checkbox = 0;
                                        ?>
                                        <?= $form->field($model,'checkbox')->checkbox(['uncheckValue' => null])->label(
                                            "<p>By submitting, I acknowledge that I've read and agree to the <a href=' https://www.propay.com/us/legal/profac-sub-merchant-terms-and-conditions' target='_blank'> ProPay Inc.</a>, <a href=' https://www.propay.com/us/legal/profac-sub-merchant-terms-and-conditions' target='_blank'>Merchant Services Terms and Conditions</a>, <a href='/company/user-requirements' target='_blank'>User Requirements</a>, <a href='/company/site-terms' target='_blank'>Site Terms</a> and <a href='/company/privacy-policy' target='_blank'>Privacy Policy</a></p>"
                                        )?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 clearfix">
                                <div class="button-grope pull-right">
                                    <?= Html::a('Cancel','/user/rented-items', ['class' =>'btn btn-line reset']) ?>
                                    <?= Html::submitButton('Create', ['class' => 'btn btn-blue']) ?>
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

