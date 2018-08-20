<?php

namespace frontend\widgets;

use app\models\Order;
use common\components\Helper;
use common\models\Setting;
use common\models\User;
use Yii;
use yii\base\Widget;

class LeftInfo extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {

        $user = User::findOne(Yii::$app->user->id);
        $rental_count = $user->getItems()->where(['deleted' => 0])->count();
        $orders_count = Order::find()->where(['user_id' => Yii::$app->user->id, 'status' => 1])->count();
        $item_count = Order::find()->where(['item_user_id' => Yii::$app->user->id, 'status' => 1])->count();

        $user_count = User::find()
            ->where(['user.status' => User::STATUS_ACTIVE])
            ->andWhere('id !=' . Yii::$app->user->id)->count();


        return $this->render("left-info", [
            'rental_count' => $rental_count,
            'orders_count' => $orders_count,
            'item_count' => $item_count,
            'user_count' => $user_count,
        ]);
    }
}

?>