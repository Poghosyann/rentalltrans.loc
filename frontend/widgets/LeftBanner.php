<?php

namespace frontend\widgets;

use common\models\Banner;
use yii\base\Widget;

class LeftBanner extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        $banners = Banner::find()->all();
        
        return $this->render("left-banner", [
            'banners' => $banners,
        ]);
    }
}

?>