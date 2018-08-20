<?php

use common\components\Helper;
use yii\helpers\Url;

?>
<div class="row videos">
    <h2 class="home-title h2-title"><?= Yii::t('frontend', 'Our partners')?></h2>
    <div class="partners-min">
        <?php foreach ($partners as $partner): ?>
            <div class="col-md-2 col-xs-4 partners">
                <a href="<?= Helper::lang($partner->url.'/'.$partner->alias); ?>">
                    <img alt="Image" src="<?= Yii::$app->params['baseUrl'] . 'uploads/partners/small_154-64_' . $partner->image ?>" />
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="<?= Helper::lang('partners'); ?>"><?= Yii::t('frontend', 'all partners')?></a>
</div>