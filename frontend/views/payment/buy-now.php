<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 4/18/2017
 * Time: 2:27 PM
 */
use common\widgets\Alert;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Buy Item';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="buy-rent">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="item-buyrent-card product-information">
                    <?= Alert::widget()?>
                    <div class="information-header">
                        <h4>Complete Your Purchase</h4>
                    </div>
                    <div class="row">
                        <div class="image-buyrent-content col-md-3 col-sm-3">
                            <img class="img-responsive" src="/images/prod-image-card.png">
                        </div>
                        <div class="col-md-9 col-sm-9 information-body">
                            <div class="card-rentbuy-title">
                                <?= $item->title?>
                            </div>
                            <div class="card-rentbuy-subtitle">
                                <?= $item->category->title?>
                            </div>
                            <div class="total-rental-price clearfix">
                                <div class="pull-left">
                                    <h4 class="buy-total">Order Total</h4>
                                </div>
                                <div class="pull-right product-price">
                                    <?= $item->replacement_cost ? $item->replacement_cost .'$' : 'N/A'?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item-buyrent-form">
                        <div class="item-buyrent-form-head clearfix">
                            <div class="item-buyrent-f-title pull-left">
                                Credit or Debit Card
                            </div>
                            <div class="hidden-xs right-paymethod-icon pull-right">
                                <img src="/images/paymethods.png">
                            </div>
                        </div>
                        <?php $form = ActiveForm::begin(['id' => 'form-order-article', 'enableClientValidation' => true, 'enableAjaxValidation' => false,
                            'action' => ['/payment/buy-now/'.$item->alias],
                            'options' => ['enctype' => 'multipart/form-data']]); ?>
                        <div class="creditcard-info">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label class="control-label">Payment Method Type <span class="required" aria-required="true"> * </span></label>
                                        <div class="form-group">
                                            <?= $form->field($model, 'payment_method_type')->dropDownList([
                                                'Visa' => 'Visa',
                                                'MasterCard' => 'MasterCard',
                                                'AMEX' => 'American Express',
                                                'Discover' => 'Discover',
                                            ],
                                                [
                                                    'class' => 'js-states form-control',
                                                    'prompt'=>''
                                                ])->label(false);?>
                                        </div>
                                    </div>
                                    <?= $form->field($model, 'name_on_card', [
                                        'template' => '<label class="control-label">Name on Card <span class="required" aria-required="true"> * </span></label>{input}',
                                    ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                    <?= $form->field($model, 'card_number', [
                                        'template' => '<label class="control-label">Card Number <span class="required" aria-required="true"> * </span></label>{input}',
                                    ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Expiration Month
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <?= $form->field($model, 'expiration_month')->dropDownList([
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
                                        ], ['class' => 'js-states form-control'])->label(false);?>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Expiration Year
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <?= $form->field($model, 'expiration_year')->dropDownList([
                                            '17' => '2017',
                                            '18' => '2018',
                                            '19' => '2019',
                                            '20' => '2020',
                                            '21' => '2021',
                                            '22' => '2022',
                                            '23' => '2023',
                                            '24' => '2024',
                                            '25' => '2025',
                                            '26' => '2026',
                                        ], ['class' => 'js-states form-control'])->label(false);?>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4 col-sm-4">
                                    <?= $form->field($model, 'cvv', [
                                        'template' => '<label class="control-label">CVV <span class="required" aria-required="true"> * </span></label>{input}',
                                    ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                </div>
                            </div>
                        </div>

                        <div class="credit-card-submition text-center">
                            <p class="caption-terms">By submitting, I agree to the <a href="/company/user-requirements" target="_blank"> User Requirements</a>, <a href="/company/site-terms" target="_blank">Site Terms</a> and <a href="/company/privacy-policy" target="_blank">Privacy Policy</a></p>
                            <?= Html::submitButton('Rent Now', ['class' => 'btn btn-blue submitStandard']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

