<?php

namespace frontend\widgets;

use common\models\Category;
use frontend\models\RentDate;
use Yii;
use yii\base\Widget;

class Search extends Widget {

    public $type;

    public function init() {
        parent::init();
    }


    public function run() {

        $categories = Category::find()->where(['status' => 1])->orderBy(['order' => SORT_ASC])->all();
        $rent_date = new RentDate();

        return $this->render("search", [
            'categories' => $categories,
            'class' => $this->type,
            'back' => Yii::$app->session->get('browse-url'),
            'rent_date' => $rent_date,
        ]);
    }
}

?>