<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$activateLink = 'https://www.rentalltrans.com/site/activate-email?token=' .  $user->activate_token;
?>

<div class="password-reset">
    <h1>Welcome</h1>
    <p>Hello <?= Html::encode($user->first_name . ' ' . $user->last_name) ?></p>
    <hr>
    <p>Follow the link below to activate your email:</p>
    <p><?= Html::a(Html::encode($activateLink), $activateLink) ?></p>
</div>