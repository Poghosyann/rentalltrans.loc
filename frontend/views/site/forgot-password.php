<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 2/22/2017
 * Time: 8:45 PM
 */
$this->title = 'Forgot Password';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->params['header_menu']  = false;
?>
<section id="signin-log">
    <div class="container">
        <div class="wrapper">
            <div class="confirmation">
                <h4 class="form-signin-heading"><?= $this->title?></h4>
                <p>
                    <?= $param?>
                </p>
                <div class="text-center">
                    <a href="/" class="btn btn-blue">Go To RentAllTrans.com</a>
                </div>
            </div>
        </div>
    </div>
</section>