<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Buy Item';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="buy-rent">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="item-buyrent-card product-information">
                    <div class="information-header">
                        <h4>Complete Your Purchase</h4>
                    </div>
                    <div class="row">
                        <div class="image-buyrent-content col-md-3 col-sm-3">
                            <img class="img-responsive" src="/images/prod-image-card.png">
                        </div>
                        <div class="col-md-9 col-sm-9 information-body">
                            <div class="card-rentbuy-title">
                                The very good item for rent
                            </div>
                            <div class="card-rentbuy-subtitle">
                                musical instruments
                            </div>
                            <div class="total-rental-price clearfix">
                                <div class="pull-left">
                                    <h4 class="buy-total">Order Total</h4>
                                </div>
                                <div class="pull-right product-price">
                                    $75
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
                        <form>
                            <div class="creditcard-info">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Name on Card
                                                <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Card Number
                                                <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Expiration Month
                                                <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <select class="js-states form-control">
                                                <option value="1">Jan</option>
                                                <option value="2">Feb</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Expiration Year
                                                <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <select class="js-states form-control">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-4 col-sm-4">
                                        <div class="form-group"><label class="control-label">
                                                CVV
                                                <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="credit-card-submition text-center">
                                <p class="caption-terms">By submitting, I agree to the <a href="">Terms and Conditions</a> and <a href="">Privacy Policy:</a></p>
                                <button type="submit" class="btn btn-blue">Buy Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
