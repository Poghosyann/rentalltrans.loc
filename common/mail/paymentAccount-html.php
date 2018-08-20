<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$sitelink = 'https://www.rentalltrans.com';
?>

<div class="password-reset">
    <h1>Welcome</h1>
    <p>Hello <?= Html::encode($user->first_name . ' ' . $user->last_name) ?></p>
    <hr>
    <?= Html::a($sitelink, $sitelink)?>
    <p>email:<?= $user->email?></p>
    <p>password:<?= $user->password?></p>
</div>