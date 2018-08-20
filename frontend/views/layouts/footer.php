<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 2/11/2017
 * Time: 1:53 PM
 */
use common\models\Page;
use yii\bootstrap\Html;

$footer_menu = Page::find()->where(['footer_menu' => 1])->orderBy(['order' => SORT_ASC])->all();
?>
<footer id="footer">
    <?if(!empty($footer_menu)):?>
    <div class="container footer-container">
        <div class="row">
            <div class="col-md-12 text-center footer-links">
                <ul>
                    <?foreach ($footer_menu as $menu):?>
                        <li><?= Html::a($menu->title, '/company/'.$menu->alias)?></li>
                    <?endforeach;?>
                </ul>
            </div>
        </div>
    </div>
    <?endif;?>
    <div class="container copyright-container">
        <div class="row">
            <div class="col-md-4 col-xs-12 text-left">
                <div class="more-info">
                    © 2017 - <?= date('Y')?>  Rent All Trans, Inc. All Rights Reserved.
                </div>
            </div>
            <div class="col-md-4 col-xs-12 text-center">
                <ul class="socials">
                    <li><a target="_blank" href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                    <li><a target="_blank" href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
                    <li><a target="_blank" href="https://plus.google.com/"><i class="fa fa-google-plus"></i></a></li>
                </ul>
            </div>
            <div class="col-md-4 col-xs-12 text-right">
                <div class="made-by">Powered by: <a href="/" target="_blank">Rent All Trans</a></div>
            </div>
        </div>
    </div>
</footer>

