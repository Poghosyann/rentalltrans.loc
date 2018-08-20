<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 2/11/2017
 * Time: 1:52 PM
 */
use frontend\models\Chat;
use yii\bootstrap\Html;
$param = Yii::$app->params['header_menu'] ?? true;
$chat_meassages = Chat::findOne(['user_id2' => Yii::$app->user->id,'status' => 'unread']);
$back = Yii::$app->session->get('browse-url');

?>
<header id="main-nav">
    <div class="container">
        <a id="mobile-go-second" data-toggle="modal" data-target="#searchModal" href="#" class="hidden-lg hidden-md">
            <i class="fa fa-search"></i>
        </a>
        <a id="mobile-message" href="/messages" class="hidden-lg hidden-md">
            <i class="fa fa-envelope-o"></i>
            <?if(!empty($chat_meassages)):?>
                <span class="badge badge-default"></span>
            <?endif;?>
        </a>
        <a id="navigation" class="hidden-lg hidden-md" href="#"><i class="fa fa-bars"></i></a>
        <div id="slide-out-menu" class="hidden-lg hidden-md">
            <a href="/" class="menu-close"><i class="fa fa-times"></i></a>
            <div class="logo"><img width="100px" src="/images/logo-light.png" alt=""></div>

            <ul>
                <? if ($param): ?>
                    <? if (Yii::$app->user->isGuest): ?>
                        <li><?= Html::a(Html::tag('i','',['class' => 'fa fa-user']). ' Sign Up', ['/site/signup'])?></li>
                        <li><?= Html::a(Html::tag('i','',['class' => 'fa fa-sign-in']). ' Log In', ['/site/login'])?></li>
                    <?else:?>
                        <li><?= Html::a(' My Profile', ['/user/edit-profile'])?></li>
                        <li>
                            <?= Html::a('Items I’ve Rented', ['/user/rented-items'])?>
                        </li>
                        <li>
                            <?= Html::a('My Rental Inventory', ['user/my-items'])?>
                        </li>
                        <li>
                            <?= Html::a('My Rented-Out Items', ['/user/my-rented-items'])?>
                        </li>

                        <li class="divider"></li>
                        <li>
                            <?= Html::a('Settings', ['/user/settings'])?>
                        </li>
                        <li><?= Html::a(Html::tag('i','',['class' => 'fa fa-sign-out']). ' Log Out ', ['/site/logout'], ['data' => ['method' => 'post',]])?></li>
                    <?endif;?>
                    <li><?= Html::a(Html::tag('i','',['class' => 'fa fa-plus']). ' Add ', [Yii::$app->user->isGuest ? '/login' : 'user/my-items/add-item' ])?></li>
                <?endif;?>
            </ul>

            <div class="slide-out-menu-footer">
                <ul class="socials">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="navbar-header">
            <?= Html::a(Html::img('/images/logo-light.png', ['alt' => 'Logo', 'width' => 100]), '/', ['class' => 'navbar-brand'])?>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="hidden-sm hidden-xs  nav navbar-nav navbar-right">
                <? if ($param): ?>
                    <? if (Yii::$app->user->isGuest): ?>
                        <li><?= Html::a(Html::tag('i','',['class' => 'fa fa-user']). ' Sign Up', ['/site/signup'])?></li>
                        <li><?= Html::a(Html::tag('i','',['class' => 'fa fa-sign-in']). ' Log In', ['/site/login'])?></li>
                    <?else:?>
                        <li class="inbox-mail">
                            <a href="/messages">
                                <i class="fa fa-envelope-o"></i>
                                <?if(!empty($chat_meassages)):?>
                                    <span class="badge badge-default"></span>
                                <?endif;?>
                            </a>
                        </li>
                        <li class="dropdown dropdown-user">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                                <img alt="" class="" src="<?= Yii::$app->user->identity->image ? '/uploads/users/115-115/'.Yii::$app->user->identity->image : '/images/default.jpg'?>">
                                <?if(Yii::$app->user->identity->display_type == 1):?>
                                    <span class="username-header"><?= Yii::$app->user->identity->first_name .' '. Yii::$app->user->identity->last_name[0]?></span>
                                <?elseif (Yii::$app->user->identity->display_type == 2):?>
                                    <span class="username-header"><?= Yii::$app->user->identity->first_name .' '. Yii::$app->user->identity->last_name?></span>
                                <?elseif (Yii::$app->user->identity->display_type == 3):?>
                                    <span class="username-header"><?= Yii::$app->user->identity->display_name?></span>
                                <?endif;?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li><?= Html::a(' My Profile', ['/user/edit-profile'])?></li>
                                <li>
                                    <?= Html::a('Items I’ve Rented', ['/user/rented-items'])?>
                                </li>
                                <li>
                                    <?= Html::a('My Rental Inventory', ['/user/my-items'])?>
                                </li>
                                <li>
                                    <?= Html::a('My Rented-Out Items', ['/user/my-rented-items'])?>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <?= Html::a('Settings', ['/user/settings'])?>
                                </li>
                                <li><?= Html::a(' Log Out ', ['/site/logout'], ['data' => ['method' => 'post',]])?></li>
                            </ul>
                        </li>
                    <?endif;?>
                    <li><?= Html::a(Html::tag('i','',['class' => 'fa fa-plus']). 'Add', [Yii::$app->user->isGuest ? '/login' : 'user/my-items/add-item' ], ['class' => 'btn btn-red'])?></li>
                <?endif;?>
            </ul>
        </div><!--/.nav-collapse -->
        <!--language-->
        <div class="lang-div">
            <i class="glyphicon glyphicon-chevron-down"></i>
            <ul>
                <li><span>eng</span></li>
                <li><span>rus</span></li>
            </ul>
        </div>
        <!--language-->
    </div>
    <div class="clearfix">
        <!--        <div class="line-red"></div>-->
        <!--        <div class="line-blue"></div>-->
    </div>
</header><!-- //Main Nav -->