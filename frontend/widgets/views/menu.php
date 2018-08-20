<?php

use common\components\Helper;
use common\components\Translate;
use yii\bootstrap\Html;
use yii\helpers\Url;
?>
<? if(!empty($menu)):?>
<nav>
    <ul class="<?= $type?>">
        <?foreach ($menu as $item):?>
            <li class="<?= $item->url == Yii::$app->request->url ? 'active' : ''?>">
                <?= Html::a($item->name, $item->url)?>
            </li>
        <?endforeach;?>
    </ul>
    <div class="navigation-title">
        Навигация
        <div class="hamburger-icon active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>
<?endif;?>