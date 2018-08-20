<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 1/27/2017
 * Time: 1:59 PM
 */
namespace frontend\widgets;

use common\models\Connection;
use common\models\HotOffer;
use common\models\User;
use frontend\models\Chat;
use Yii;
use yii\base\Widget;
use yii\web\NotFoundHttpException;

class LeftInfo2 extends Widget {

    public function init() {
        parent::init();
    }

    public $alias;

    public function run() {

        $user = User::findOne(['status' => User::STATUS_ACTIVE, 'username' => $this->alias]);
        $login_user = User::findOne(['status' => User::STATUS_ACTIVE, 'id' => Yii::$app->user->id]);
        $rental_count = $user->getItems()->where(['item.status' => 'available'])->count();
        $con = [];
        $arr = [];
        $connection = Connection::findOne(['user_id' => Yii::$app->user->id, 'user_id1' => $user->id]);

        if (empty($user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }


        if(!Yii::$app->user->isGuest){

            foreach ($login_user->getConnections()->all() as $item){
                $con[$item->user_id1] = $item->user_id1;
            }

            foreach ($user->getConnections()->all() as $i){
                if (in_array($i->user_id1, $con)) {
                    $arr[$i->user_id1] = $i->user_id1;
                }
            }
            $degree = Connection::degree($user->id);
        }

        $chat_model = new Chat();

        return $this->render("left-info2", [
            'user' => $user,
            'connection' => $connection,
            'rental_count' => $rental_count,
            'connection_count' => count($arr),
            'degree' => $degree,
            'chat_model' => $chat_model,
        ]);
    }
}

?>