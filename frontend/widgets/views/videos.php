<?php

use common\components\Helper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>

<div class="col-md-6 videos">
    <p class="behind-line title24"><span><?= Yii::t('frontend', 'Videos')?></span></p>
    <div id="videos" class="carousel slide" data-ride="carousel" data-interval="false">
        <!-- Indicators -->
        <div class="carousel-inner" role="listbox" style="width:100%">            
            <?php $i = 0;?>
            <?php foreach ($videos as $video):?>       
                <div class="item <?= ($i == 0)? 'active': '';?>">
                    <div class="video-wr">
                        <a href="javascript:void(0)" class="hidden-xs">
                                  <?php
                        Modal::begin([
                            'toggleButton' => [
                                'tag' => 'img',
                                'src' => '/uploads/video/small_330-197_' . $video->image,
                                'class'=>'radius',
                            ]
                        ]);
                        ?>    
<img class="radius" alt="" src="<?=Yii::$app->params['baseUrl'] . '/uploads/video/small_330-197_' . $video->image?>">                        
                        <iframe class="hidden-xs"  width="560" height="315" src="<?= $video->url_video?>" frameborder="0" allowfullscreen></iframe>
                        
                        <?php
                        Modal::end();
                        ?>                        
                        </a>
<img class="radius visible-xs" alt="" src="<?=Yii::$app->params['baseUrl'] . '/uploads/video/small_330-197_' . $video->image?>">

                    </div>
                </div>
                <?php $i ++;?>
            <?php endforeach;?>
        </div>
        <a class="left carousel-control" href="#videos" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left icon-arrow_left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#videos" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right icon-arrow_right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <a href="<?= Helper::lang('videos'); ?>"><?= Yii::t('frontend', 'all videos')?></a>
</div>