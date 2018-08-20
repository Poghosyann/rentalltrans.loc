<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 10/11/2016
 * Time: 10:16 PM
 */
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
?>
<div class="add-items sidebar-body toTheTop">
    <div class="profile-userpic">
        <img src="<?= Yii::$app->user->identity->image ? '/uploads/users/'.Yii::$app->user->identity->image : '/images/default.jpg'?>" class="img-responsive" alt="">
        <a href="/user/settings" class="profile-edit"><i class="fa fa-gear"></i></a>
    </div>
    <?if(Yii::$app->user->identity->display_type == 1):?>
        <div class="profile-usertitle-name"><?= Yii::$app->user->identity->first_name .' '. Yii::$app->user->identity->last_name[0]?></div>
    <?elseif (Yii::$app->user->identity->display_type == 2):?>
        <div class="profile-usertitle-name"><?= Yii::$app->user->identity->first_name .' '. Yii::$app->user->identity->last_name?></div>
    <?elseif (Yii::$app->user->identity->display_type == 3):?>
        <div class="profile-usertitle-name"><?= Yii::$app->user->identity->display_name?></div>
    <?endif;?>
    <div class="profile-usermenu">
        <ul>
            <li>
                <a href="/user/rented-items" class="<?= Yii::$app->request->url == '/user/rented-items' ? 'active' : ''?>">
                    <span class="pull-right"><?= $orders_count?></span>
                    Items I’ve Rented
                </a>
            </li>
            <li>
                <a href="/user/my-items" class="<?= Yii::$app->request->pathInfo == 'user/my-items' ? 'active' : ''?>">
                    <span class="pull-right"><?= $rental_count?></span>
                    My Rental Inventory
                </a>
            </li>
            <li>
                <a href="/user/my-rented-items" class="<?= Yii::$app->request->pathInfo == 'user/my-rented-items' ? 'active' : ''?>">
                    <span class="pull-right"><?= $item_count?></span>
                    My Rented-Out Items
                </a>
            </li>
        </ul>
    </div>
    <div class="profile-userbuttons">
        <a href="/user/edit-profile" type="button" class="btn btn-blue"><i class="fa fa-pencil"></i> Edit Profile</a>
    </div>
</div>