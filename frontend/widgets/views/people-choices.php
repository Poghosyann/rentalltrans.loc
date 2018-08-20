<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 1/27/2017
 * Time: 1:32 PM
 */

?>
<?if(!empty($people_choices)):?>
    <div class="swiper-container arrows-align-top">
        <div class="h4 swiper-title">выбор людей</div>
        <div class="empty-space col-xs-b20"></div>
        <div class="swiper-button-prev style-1"></div>
        <div class="swiper-button-next style-1"></div>
        <div class="swiper-wrapper">
            <?foreach ($people_choices as $people_choice):?>
                <div class="swiper-slide">
                <div class="banner-shortcode style-1">
                    <div class="background" style="background-image: url(<?= '/uploads/people-choices/850-340/'.$people_choice->image?>);"></div>
                    <div class="description valign-middle">
                        <div class="valign-middle-content">
                            <div class="h4 light"><?= $people_choice->title?></div>
                            <div class="empty-space col-xs-b25"></div>
                            <a class="button size-1 style-3" href="<?= $people_choice->url?>">
                                <span class="button-wrapper">
                                    <span class="icon"><img src="/img/icon-4.png" alt=""></span>
                                    <span class="text">Смотреть </span>
                                </span>
                            </a>
                        </div>
                        <div class="empty-space col-xs-b60 col-sm-b0"></div>
                    </div>
                </div>
            </div>
            <?endforeach;?>
        </div>
        <div class="swiper-pagination visible-xs"></div>
    </div>
<?endif;?>