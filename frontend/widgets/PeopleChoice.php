<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 1/27/2017
 * Time: 1:32 PM
 */

namespace frontend\widgets;

use yii\base\Widget;

class PeopleChoice extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {

        $people_choices = \common\models\PeopleChoice::find()->orderBy(['order' => SORT_ASC])->all();

        return $this->render("people-choices", [
            'people_choices' => $people_choices
        ]);
    }
}

?>