<?php

namespace frontend\widgets;

use frontend\components\Session;
use yii\base\Widget;
use common\models\News as NewsModel;

class History extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {


        $history_list = Session::historyList();

        return $this->render("history", [
            'history_list' => $history_list,
        ]);
    }
}

?>