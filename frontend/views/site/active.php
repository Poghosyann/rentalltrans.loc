<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 2/16/2017
 * Time: 1:20 PM
 */

$this->title = 'Sign Up Confirmation';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->params['header_menu']  = false;
?>
<section id="signin-log">
    <div class="container">
        <div class="wrapper">
            <div class="confirmation">
                <h4 class="form-signin-heading">Thank You For Signing Up</h4>
                <p>
                    We just sent you an email with a link to confirm your email address.
                    Please find the email and click to confirmation link.
                </p>
                <p class="login-options">If you do not receive the confirmation email within 2 minutes please check your spam folder.</p>
                <div class="text-center">
                    <a href="/" class="btn btn-blue">Go To RentAllTrans.com</a>
                </div>
            </div>
        </div>
    </div>
</section>

