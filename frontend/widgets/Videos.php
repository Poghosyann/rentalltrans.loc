<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\Video;

class Videos extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        $videos = Video::find()->orderBy(['id' =>SORT_DESC])->limit(3)->all();
        
        return $this->render("videos", [
            'videos' => $videos,
        ]);
    }
}

?>