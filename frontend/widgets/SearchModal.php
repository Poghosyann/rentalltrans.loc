<?php

namespace frontend\widgets;

use Codeception\Lib\Generator\Helper;
use common\models\Category;
use common\models\ClassItem;
use common\models\Marka;
use common\models\Model;
use common\models\User;
use frontend\models\RentDate;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class SearchModal extends Widget {

    public function init() {

        User::updateAll( ['user.hide_items' => 1], ['and',
            ['<=', 'user.hide_from', Yii::$app->formatter->asDate('now', 'php:Y-m-d')],
            ['>=', 'user.hide_to', Yii::$app->formatter->asDate('now', 'php:Y-m-d')],
        ]);

        User::updateAll( ['user.hide_items' => 0], ['and',
            ['<', 'user.hide_to', Yii::$app->formatter->asDate('now', 'php:Y-m-d')],
            ['is not', 'user.hide_to', null]
        ]);

        parent::init();
    }

    public function run() {

        $categories = Category::find()->where(['status' => 1])->orderBy(['order' => SORT_ASC])->all();
        $rent_date = new RentDate();
        $users = User::find()->where(['role' => 'user'])->all();
        $user_data = [];

        $class = ArrayHelper::map(ClassItem::find()->all(),'id', 'title');
        $marka = ArrayHelper::map(Marka::find()->orderBy(['mark' => SORT_ASC])->all(),'id', 'mark');

        $marka_id = Yii::$app->request->get('marka');

        $model = ArrayHelper::map(Model::find()->where(['mark_id' => $marka_id])->all(), 'id', 'model');

        foreach ($users as $user){

            if($user->display_type == 1){
                $user_name = $user->first_name .' '.$user->last_name[0];
            }elseif ($user->display_type == 2){
                $user_name = $user->first_name .' '.$user->last_name;
            }elseif ($user->display_type == 23){
                $user_name = $user->display_name;
            }
            $user_data[$user->username] = $user_name;
        }

        return $this->render("search-modal", [
            'categories' => $categories,
            'back' => Yii::$app->session->get('browse-url'),
            'rent_date' => $rent_date,
            'users' => $user_data,
            'class' => $class,
            'marka' => $marka,
            'model' => (!empty($model)) ? $model : [],
        ]);
    }
}

?>