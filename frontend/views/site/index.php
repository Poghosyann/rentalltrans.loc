<?php

/* @var $this yii\web\View */

use frontend\widgets\SearchModal;
use wadeshuler\jwplayer\JWPlayer;
use yii\bootstrap\Html;
use frontend\widgets\Search;

$this->title = 'Rent All Trans';
?>
<section id="header">
<?if(!empty($sliders)):?>
    <!-- Wrapper for slides -->
    <div class="slider-wrapper">
        <!--style="background: url('./uploads/sliders/6DR-gpchytqoi2uz0rf8.jpg') no-repeat center center">-->
        <div class="carousel-caption-inner">
            <h2 class="">Do your best choice!&trade;</h2>
            <!--this div with class 'form-container'-->
            <?= Search::widget(['type' => 'btn-blue'])?>
            <!--this div with class 'form-container'-->

            <div id="main-carousel">
                <?foreach ($sliders as  $slider):?>
                    <div class="sl-cont">
                        <?= Html::img('/uploads/sliders/'. $slider->image, ['alt' => 'img'])?>
                        <div class="sl-text">
                            <p class="hidden-xs slider-text">
                                <?= $slider->text?>
                            </p>
                        </div>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </div>
<?endif;?>
</section><!-- //Header -->
    <section class="container">
        <div id="rek" class="row">
            <!--this tree block -->
            <div class="rek col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <a class="btn btn-blue" href="#">My voucher</a>
            </div>

            <div class="rek col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <a class="btn btn-blue" href="#">Change reservation</a>
            </div>

            <div class="rek col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <a class="btn btn-blue" href="#">Best price</a>
            </div>
            <!--this tree block -->
        </div>
    </section>
<!-- //how it works -->
<?= SearchModal::widget()?>