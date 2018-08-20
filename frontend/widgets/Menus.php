<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\Menu as MenuModel;

class Menus extends Widget {

    public $type;

    public function init() {
        parent::init();
    }

    public function run() {
        $menu = MenuModel::find()->orderBy(['order' => SORT_ASC])->all();
        
        return $this->render("menu", [
            'menu' => $menu,
            'type' => $this->type,
        ]);
    }
}

?>