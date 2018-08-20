<?php

namespace frontend\widgets;


use yii\base\Widget;

class Social extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        $social = \common\models\Social::find()->orderBy(['order' =>SORT_ASC])->all();

        return $this->render("social", [
            'social' => $social,
        ]);
    }
}

?>