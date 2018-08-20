<?php

namespace frontend\widgets;

use common\models\Category;
use yii\base\Widget;

class LeftFilter extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {

        $categories = Category::find()->where(['status' => 1])->orderBy(['order' => SORT_ASC])->all();
        
        return $this->render("left-filter", [
            'categories' => $categories,
        ]);
    }
}

?>