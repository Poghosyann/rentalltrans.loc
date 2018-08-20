<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\Shops as ShopsModel;
use common\models\LanguagesHasShops;

class Shops extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        $shops = ShopsModel::find()->all();

        return $this->render("shops", [
            'shops' => $shops,
        ]);
    }
}

?>