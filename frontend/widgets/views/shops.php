<?php

use common\components\Helper;
use yii\helpers\Url;

?>

<h3 class="home-title white">СЕТЬ МАГАЗИНОВ</h3>
<div class="container">
    <div class="row">
        <?php foreach ($shops as $shop): ?>            
            <div class="col-md-4 col-xs-6">
                <a href="<?= Helper::lang($shop->url.'/'.$shop->alias); ?>">
                    <img alt="" src="<?= Yii::$app->params['baseUrl'] . 'uploads/shops/large_289-195_' . $shop->image ?>" />
                </a>                
                <p>
                    <?=$shop->getLanguagesHasShops()->all()[0]->address?><br />
                    <?=$shop->phone?>
                </p>
            </div>    
        <?php endforeach; ?>            
    </div>
</div>