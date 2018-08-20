<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\LanguagesHasPartners;
use common\models\Partners as PartnersModel;

class Partners extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        $partners = PartnersModel::find()->orderBy(['order' => SORT_ASC])->limit(18)->all();
       
        return $this->render("partners", [
            'partners' => $partners,
        ]);
    }
}

?>