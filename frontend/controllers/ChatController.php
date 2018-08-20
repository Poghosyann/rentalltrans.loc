<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 4/13/2017
 * Time: 12:30 PM
 */

namespace frontend\controllers;

use app\models\Order;
use common\components\Helper;
use common\controllers\AuthController;
use common\models\Connection;
use common\models\User;
use frontend\models\Chat;
use frontend\widgets\ChatRoom;
use Yii;
use yii\web\NotFoundHttpException;

class ChatController extends AuthController
{
    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionSendChat() {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (!empty($_POST)) {
            echo $this->sendChat($_POST);
        }
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionUpdateUser() {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (!empty($_POST)) {

            $dey = Yii::$app->request->post('dey');

            $session = Yii::$app->session;
            Yii::$app->session->get('chat-user');

            if($session->isActive){
                $item_session = [
                    'dey' => $dey,
                ];
                Yii::$app->session->set('chat-user', $item_session);
            }
            $data = Yii::$app->session->get('chat-user');

            $model = new Chat();

           print($model->chatUser($data['dey']));
        }
    }

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionMessages($alias){

        $users = User::find()->where(['status' => User::STATUS_ACTIVE, 'deleted' => 1, 'role' => 'user'])->all();
        $user2 = User::findOne(['username' => $alias, 'status' => User::STATUS_ACTIVE]);

        $rent = Chat::find()->where([
            'user_id2' => [$user2->id, Yii::$app->user->id],
            'userId' => [$user2->id, Yii::$app->user->id],
            'type' => 'rent'
        ])->orderBy(['id' => SORT_ASC])->asArray()->one();

        if (empty($user2) && !empty($alias)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $order_id = Yii::$app->request->get('order_id');

        if(!empty($order_id)){
            $order = Order::findOne(['id' => $order_id]);
            $order_id = $order->id;

            if (empty($order)) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        Chat::updateAll([ 'status' => 'read'],['status' => 'unread','userId' => $user2->id, 'user_id2' => Yii::$app->user->id]);

        $model = new Chat();
        $data = $model->data($user2->id, $order_id);
        $chat_users = $model->chatUser();

        $user_data = Yii::$app->session->get('chat-user');
        if (empty($alias)){
            unset($user_data);
        }

        return $this->render('messages', [
            'data' => $data,
            'user2' => $user2,
            'chat_users' => $chat_users,
            'users' => $users,
            'model' => $model,
            'rent' => $rent,
            'order_id' => $order_id,
            'order' => $order,
            'user_data' => $user_data
        ]);
    }

    /**
     * @param $post
     * @throws NotFoundHttpException
     */
    public function sendChat($post) {

        $alias = Yii::$app->request->post('alias');
        $orderid = Yii::$app->request->post('orderid');
        $user2 = User::findOne(['username' => $alias, 'status' => User::STATUS_ACTIVE]);

        if (empty($user2)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $message = null;
        if (isset($post['message'])){
            $message = $post['message'];
        }

        $model = new Chat;
        if (!empty($message)) {

            $model = new Chat;
            $model->message = $message;
            $model->userId = Yii::$app->user->id;
            $model->user_id2 = $user2->id;
            if(!empty($orderid)){
                $model->type = 'rent';
                $model->order_id = $orderid;
            }

            if ($model->save()) {
                echo $model->data($user2->id, $orderid);
            } else {
                print_r($model->getErrors());
                exit(0);
            }
        } else {
            echo $model->data($user2->id, $orderid);
        }
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSendMessages(){

        $model = new Chat();

        $post = Yii::$app->request->post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (!empty(Yii::$app->request->get('alias'))){
                return $this->redirect(['/item/'.Yii::$app->request->get('alias')]);
            }else{
                return $this->redirect($post['Chat']['base_url']);
            }
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}