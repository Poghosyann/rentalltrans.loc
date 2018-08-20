<?php
use yii\bootstrap\Html;

?>

<br>
<div class="col-sm-6 col-md-12">
    <div class="h4 col-xs-b25">НАИБОЛЕЕ ПРОСМАТРИВАЕМЫЕ</div>

        <? foreach($history_list as $history):?>
            <?if($k++ <= 5):?>
                <div class="product-shortcode style-4 clearfix">
                    <?= Html::a(Html::img('/uploads/products/70-70/'.$history['path']), '/anketa/'.$history['alias'], ['class' => 'preview'])?>
                    <div class="description">
                        <h6 class="h6 col-xs-b10"><a href="/anketa/<?= $history['alias']?>"><?= $history['title']?></a></h6>
                        <div class="simple-article dark"><?= $history['price']?> руб</div>
                    </div>
                </div>
                <div class="col-xs-b10"></div>
            <?endif;?>
        <?endforeach;?>
    </div>
    <div class="empty-space col-xs-b25 col-sm-b50"></div>
</div>

