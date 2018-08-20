<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 2/16/2017
 * Time: 1:20 PM
 */

$this->title = 'Payment Account';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->params['header_menu']  = false;
?>
<section id="signin-log">
    <div class="container">
        <div class="wrapper">
            <div class="confirmation">
                <h4 class="form-signin-heading">Create Payment Account</h4>
                <p>
                    Your payment account is successfully created. For the future payment account changes we sent you an email with instructions.
                </p>
                <p class="login-options">Your rental item is successfully published.</p>
                <div class="text-center">
                    <a href="/user/my-items" class="btn btn-blue">Go To My Items To Rent</a>
                </div>
            </div>
        </div>
    </div>
</section>

