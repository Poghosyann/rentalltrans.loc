<?php

namespace frontend\widgets;

use common\models\Slider As Sliders;
use yii\base\Widget;

class Slider extends Widget {

    public function init() {
        parent::init();
    }

    /**
     * @return string
     */
    public function run() {
        $sliders = Sliders::find()->orderBy(['order' => SORT_ASC])->all();
        return $this->render("slider", [
            'sliders' => $sliders,
        ]);
    }
}

?>