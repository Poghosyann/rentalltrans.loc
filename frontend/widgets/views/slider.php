<? use yii\bootstrap\Html;

if(!empty($sliders)):?>
<div class="slider-wrapper">
    <div class="swiper-button-prev visible-lg"></div>
    <div class="swiper-button-next visible-lg"></div>
    <div class="swiper-container" data-parallax="1" data-auto-height="1">
        <div class="swiper-wrapper">
            <?foreach ($sliders as $slider):?>
                <div class="swiper-slide">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="cell-view page-height">
                                <div class="col-xs-b40 col-sm-b80"></div>
                                <div data-swiper-parallax-x="-600">
                                    <div class="simple-article white size-5">Лучащая цена <span class="color"><?= number_format($slider->price, 0, ' ', ' ')?> руб</span></div>
                                    <div class="col-xs-b5"></div>
                                </div>
                                <div data-swiper-parallax-x="-500">
                                    <h1 class="h1 white"><?= $slider->title?></h1>
                                    <div class="title-underline left"><span></span></div>
                                </div>
                                <div data-swiper-parallax-x="-400">
                                    <div class="simple-article size-4 white"><?= $slider->description?></div>
                                    <div class="col-xs-b30"></div>
                                </div>
                                <div data-swiper-parallax-x="-300">
                                    <div class="buttons-wrapper">
                                        <a class="button size-2 style-2" href="<?= $slider->url?>">
                                            <span class="button-wrapper">
                                                <span class="icon"><img src="/img/icon-1.png" alt=""></span>
                                                <span class="text">Узнать больше</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-b40 col-sm-b80"></div>
                            </div>
                        </div>
                    </div>
                    <div class="slider-product-preview">
                        <div class="product-preview-shortcode">
                            <div class="preview">
                                <div class="swiper-lazy-preloader"></div>
                                <?foreach($slider->sliderImages as $image):?>
                                    <div class="entry full-size swiper-lazy <?= $image->path == $slider->sliderImage->path ? 'active' : ''?>" data-background="<?= '/uploads/sliders/485-485/'.$image->path?>"></div>
                                <?endforeach;?>
                            </div>
                            <div class="sidebar valign-middle" data-swiper-parallax-x="-300">
                                <div class="valign-middle-content">
                                    <?foreach($slider->sliderImages as $image):?>
                                        <div class="entry <?= $image->path == $slider->sliderImage->path ? 'active' : ''?>">
                                            <?= Html::img('/uploads/sliders/485-485/'.$image->path, ['alt' => $slider->title])?>
                                        </div>
                                    <?endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="empty-space col-xs-b80 col-sm-b0"></div>
                </div>
            </div>
            <?endforeach;?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
<?endif;?>