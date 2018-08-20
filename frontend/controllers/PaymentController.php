<?php

namespace frontend\controllers;

use app\models\Order;
use common\components\Arca;
use common\controllers\AuthController;
use common\models\Item;
use common\models\OrderHasCompanyProduct;
use frontend\models\Chat;
use common\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

class PaymentController extends AuthController
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
	 * @param $status
	 * @param $orderid
	 * @return \yii\web\Response
	 * @throws NotFoundHttpException
	 */
	public function actionStatus($status, $orderid){

        $order = Order::find()
	            ->with('user')
	            //->with('companyProducts')
	            ->with(['item' => function(ActiveQuery $query){
	            	$query->with('model', 'category', 'class', 'transmissionVehicles', 'typeBody');
	            }])
	            ->where(['id' => $orderid])
	            ->one();
        if (empty($order)) {
	        throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (($status == 1) && ($order->status == 0)){

            if (!empty($order->orderId)) {
	            $url = 'https://ipay.arca.am/payment/rest/getOrderStatusExtended.do?userName='.Arca::USERNAME.'&password='.Arca::PASSWORD.'&orderId=' . $order->orderId . '&language='.Arca::LANGUAGE;
	            $ch = curl_init();

	            curl_setopt($ch, CURLOPT_URL, $url);
	            curl_setopt($ch, CURLOPT_HEADER, false);
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

	            $MDORDER = trim(curl_exec($ch));
	            curl_close($ch);

	            $param = json_decode($MDORDER);

            }else{
	            throw new NotFoundHttpException('The requested page does not exist.');
            }

	        //Call Parse Function for the XML response
            $chat = new Chat();

            if ($param->actionCode == 0){

	            $chat->message = "Accepted rental request <br>".$param->actionCodeDescription." - ". $param->actionCode;
	            $order->status = 1;
	            $order->save();

	            $order->sendSms($order->getUserPhone($order->user_id), "Your reservation has been accepted! rentalltrans.com");
	            //$order->sendSms($order->getUserPhone(Yii::$app->user->id), "Դուք հաջողությամբ հաստատեցիք ամրագրումը: rentalltrans.com");
	            $order->emailApproved($order);
	            $order->emailOwnerRenter();
            }else{
	            $chat->message = "Rental request rejected. <br>".$param->actionCodeDescription." - ". $param->actionCode;
	            $order->status = 2;
	            $order->save();

	            $order->emailRejected($order);
            }

            $chat->userId = Yii::$app->user->id;
            $chat->user_id2 = $order->user_id;
            $chat->type = 'rent';
            $chat->order_id = $order->id;
            $chat->save();
        }elseif(($status == 2) && ($order->status == 0)){
            $chat = new Chat();
            $chat->message = 'Request is canceled by the owner';
            $chat->userId = Yii::$app->user->id;
            $chat->user_id2 = $order->user_id;
            $chat->type = 'rent';
            $chat->order_id = $order->id;
            $chat->save();

            $order->status = 2;
            $order->save();

	        $order->sendSms($order->getUserPhone($order->user_id), "Your reservation has been canceled! rentalltrans.com");
	        $order->emailRejected($order);
        }elseif(($status == 3) && ($order->status == 0)){
            $chat = new Chat();
            $chat->message = 'Request is canceled by the user';
            $chat->userId = Yii::$app->user->id;
            $chat->user_id2 = $order->item_user_id;
            $chat->type = 'rent';
            $chat->order_id = $order->id;
            $chat->save();

            $order->status = 3;
            $order->save();
            $order->emailRejected($order);

            return $this->redirect(['/messages/'.$order->itemUser->username.'?order_id='.$order->id]);
        }
        elseif(($status == 4) && ($order->status == 1)){

	        $chat = new Chat();
	        $chat->message = 'Request is canceled by the user';
	        $chat->userId = Yii::$app->user->id;
	        $chat->user_id2 = $order->item_user_id;
	        $chat->type = 'rent';
	        $chat->order_id = $order->id;
	        $chat->save();

	        $order->status = 4;
	        $order->save();
	        $order->emailRejectedUser($order);
	        $order->sendSms($order->getUserPhone($order->item_user_id), "Հաճախորդը չեղարկել է ամրագրումը rentalltrans.com կայքում:");

	        return $this->redirect(['/messages/'.$order->itemUser->username.'?order_id='.$order->id]);
        }
        elseif(($status == 5) && ($order->status == 1)) {
	        $chat = new Chat();
	        $chat->message = 'Request is canceled by the owner';
	        $chat->userId = Yii::$app->user->id;
	        $chat->user_id2 = $order->user_id;
	        $chat->type = 'rent';
	        $chat->order_id = $order->id;
	        $chat->save();

	        $order->status = 5;
	        $order->save();
	        $order->emailRejectedClient($order);
	        $order->sendSms($order->getUserPhone($order->user_id), "Your reservation has been canceled! rentalltrans.com");
        }

		return $this->redirect(['/messages/'.$order->user->username.'?order_id='.$order->id]);

    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionPay(){
        $post = Yii::$app->request->post();

        if ($post){

            $arr = $post['RentPrice']['additional'];
            $arr = array_diff($arr, ['0']);

            $session = Yii::$app->session;

            if($session->isActive){
                Yii::$app->session->set('additional-services', $arr);
            }

            $item_session = Yii::$app->session->get('rent-now');
            $additional_services = Yii::$app->session->get('additional-services');
            $additional_price = '';

            foreach ($additional_services as $additional_service){
                $additional_price += $additional_service;
            }

            $total_price =  100;//$item_session['total_price'] + $additional_price;

            $redirect_url = 'http://rentalltrans.com/payment/order';
            $arca = new Arca();
            $payment = json_decode($arca->get_form2(time(), $total_price, $redirect_url)[0]);

            $user = User::find()
	            ->where(['id' => Yii::$app->user->id])
	            ->one();
            
	        if((isset($user['cell_phone']) && empty($user['cell_phone'])) || (isset($user['address_line_1']) && empty($user['address_line_1']))){
		        return $this->redirect('/user/edit-profile');
	        }

            return $this->redirect($payment->formUrl);

        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $orderId
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionOrder($orderId){

        $item_session = Yii::$app->session->get('rent-now');
        $additional_services = Yii::$app->session->get('additional-services');
        $additional_price = '';

        foreach ($additional_services as $additional_service){
            $additional_price += $additional_service;
        }

        $item = Item::findOne($item_session['id']);

        if (empty($item)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $order = new Order();
        $order->user_id = Yii::$app->user->id;
        $order->item_user_id = $item_session['item_user_id'];
        $order->item_id = $item_session['id'];
        $order->from = Yii::$app->formatter->asDate($item_session['from'], 'php:Y-m-d');
        $order->to = Yii::$app->formatter->asDate($item_session['to'], 'php:Y-m-d');
        $order->rental_price = $item_session['total_price'];
        $order->service_price = $additional_price;
        $order->orderId = $orderId;

        if($order->save()){
	       // $order->sendSms($order->user->cell_phone, "Your booking is not yet confirmed. You will receive a response to the booking confirmation within 24 hours. rentalltrans.com");
	        $order->sendSms($order->itemUser->cell_phone, "Ձեր ՏՄ ամրագրված է! խնդրում ենք հաստատել ամրագրումը: rentalltrans.com");
            foreach ($additional_services as $k => $company_item){

                $model_compny = new OrderHasCompanyProduct();
                $model_compny->order_id = $order->id;
                $model_compny->company_product_id = $k;
                $model_compny->save();
            }

            $chat = new Chat();
            $chat->message = 'Sent a rental request';
            $chat->userId = Yii::$app->user->id;
            $chat->user_id2 = $item_session['item_user_id'];
            $chat->order_id = $order->id;
            $chat->save();

	        $order->emailRefundClient($order);
	        $order->emailRefundUser($order);
        }

        return $this->redirect('/messages/'.$item->user->username.'?order_id='.$order->id);
    }
}