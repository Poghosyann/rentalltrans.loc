<?php

namespace app\models;

use common\models\ClassItem;
use common\models\CompanyProduct;
use common\models\Item;
use common\models\Model;
use common\models\OrderHasCompanyProduct;
use common\models\TransmissionVehicles;
use common\models\TypeBody;
use common\models\User;
use frontend\models\Chat;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $type
 * @property integer $status
 * @property integer $user_id
 * @property string $from
 * @property string $to
 * @property string $orderId
 * @property string $rental_price
 * @property string $service_price
 * @property string $created
 * @property string $updated
 * @property integer $item_user_id
 * @property integer $item_id
 *
 * @property User $user
 * @property User $itemUser
 * @property Item $item
 * @property Model $model
 * @property ClassItem $class
 * @property TransmissionVehicles $transmission
 * @property TypeBody $typeBody
 * @property Chat[] $chats
 * @property OrderHasCompanyProduct $orderHasCompanyProduct
 * @property CompanyProduct $CompanyProduct
 */

class Order extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
                'value' => new Expression('NOW()'),

            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'user_id', 'item_user_id', 'item_id'], 'integer'],
            [['user_id', 'item_user_id', 'item_id'], 'required'],
            [['from', 'to', 'created', 'updated'], 'safe'],
            [['rental_price', 'service_price'], 'number'],
            [['orderId'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'status' => 'Status',
            'user_id' => 'User ID',
            'from' => 'From',
            'to' => 'To',
            'rental_price' => 'Rental Price',
            'service_price' => 'Service Price',
            'created' => 'Created',
            'updated' => 'Updated',
            'item_user_id' => 'Item User ID',
            'item_id' => 'Item ID',
            'orderId' => 'Order ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemUser()
    {
        return $this->hasOne(User::className(), ['id' => 'item_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTransmissionVehicles()
	{
		return $this->hasOne(TransmissionVehicles::className(), ['id' => 'transmission_id']);
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['order_id' => 'id']);
    }

    // Email messages

    public function emailOwnerRenter(){

        $order = Order::findOne($this->id);

        if (empty($order)) {
            return false;
        }

	    return Yii::$app->mailer->compose('renterRentalRequest-html',
            [
	            'results_product_item' => $this->getServices($this->id),
	            'casco_insurance_price' => $this->getInsuranceStatus($this->id),
                'order' => $order,
                'htmlLayout' => 'layouts/html',
                'text' => 'passwordResetToken-text',
            ])
            ->setFrom([Yii::$app->params['supportEmail'] => 'Rent All Trans'])
            ->setTo($order->itemUser->email)
            ->setSubject('Confirmation of your rental request') //tirojy acceptic heto
            ->send();
    }

    public function emailApproved($order){

        if (empty($order)) {
            return false;
        }

        return Yii::$app->mailer->compose('approvedRentalRequest-html',
            [
	            'results_product_item' => $this->getServices($this->id),
	            'casco_insurance_price' => $this->getInsuranceStatus($this->id),
                'order' => $order,
                'htmlLayout' => 'layouts/html',
                'text' => 'passwordResetToken-text',
            ])
            ->setFrom([Yii::$app->params['supportEmail'] => 'Rent All Trans'])
            ->setTo($order->user->email)
            ->setSubject('Your rental request has been approved')  //clientin accepti jamanak
            ->send();

    }

    public function emailRejected($order){

        if (empty($order)) {
            return false;
        }

        return Yii::$app->mailer->compose('rejectedRentalRequest-html',
            [
	            'results_product_item' => $this->getServices($this->id),
	            'casco_insurance_price' => $this->getInsuranceStatus($this->id),
                'order' => $order,
                'htmlLayout' => 'layouts/html',
                'text' => 'passwordResetToken-text',
            ])
            ->setFrom([Yii::$app->params['supportEmail'] => 'Rent All Trans'])
            ->setTo($order->user->email)
            ->setSubject('Your rental request has been canceled') //clientin accepti poxaren canceli jamanak
            ->send();
    }

    public function emailRejectedUser($order){
	    if (empty($order)) {
		    return false;
	    }

	    return Yii::$app->mailer->compose('ownerRefundRequest-html',
		    [
			    'results_product_item' => $this->getServices($this->id),
			    'casco_insurance_price' => $this->getInsuranceStatus($this->id),
			    'order' => $order,
			    'htmlLayout' => 'layouts/html',
			    'text' => 'passwordResetToken-text',
		    ])
		    ->setFrom([Yii::$app->params['supportEmail'] => 'Rent All Trans'])
		    ->setTo($order->itemUser->email)
		    ->setSubject('The customer canceled the order') //tirojy erb clienty acceptic heto cancela anum
		    ->send();
    }

    public function emailRejectedClient($order){
	    if (empty($order)) {
		    return false;
	    }

	    return Yii::$app->mailer->compose('rejectedRentalRequest-html',
		    [
			    'results_product_item' => $this->getServices($this->id),
			    'casco_insurance_price' => $this->getInsuranceStatus($this->id),
			    'order' => $order,
			    'htmlLayout' => 'layouts/html',
			    'text' => 'passwordResetToken-text',
		    ])
		    ->setFrom([Yii::$app->params['supportEmail'] => 'Rent All Trans'])
		    ->setTo($order->user->email)
		    ->setSubject('Your rental request has been canceled') //clientin acceptic heto canceli jamanak
		    ->send();
    }

	public function emailRefundUser($order){
		if (empty($order)) {
			return false;
		}

		return Yii::$app->mailer->compose('renterRefundRequest-html',
			[
				'results_product_item' => $this->getServices($this->id),
				'casco_insurance_price' => $this->getInsuranceStatus($this->id),
				'order' => $order,
				'htmlLayout' => 'layouts/html',
				'text' => 'passwordResetToken-text',
			])
			->setFrom([Yii::$app->params['supportEmail'] => 'Rent All Trans'])
			->setTo($order->itemUser->email)
			->setSubject('Someone wants to rent your car. ')  // tirojy minchev accepty
			->send();
	}

	public function emailRefundClient($order){
		if (empty($order)) {
			return false;
		}

		return Yii::$app->mailer->compose('approvedRefundRequest-html',
			[
				'results_product_item' => $this->getServices($this->id),
				'casco_insurance_price' => $this->getInsuranceStatus($this->id),
				'order' => $order,
				'htmlLayout' => 'layouts/html',
				'text' => 'passwordResetToken-text',
			])
			->setFrom([Yii::$app->params['supportEmail'] => 'Rent All Trans'])
			->setTo($order->user->email)
			->setSubject('Waiting for acceptance.')  // clientin minchev accepty
			->send();
	}

	public function getInsuranceStatus($order_prd_id){
        $price = false;
		$results_company = Yii::$app->db->createCommand(
			"SELECT * FROM `order_has_company_product` WHERE `order_id`= ".$order_prd_id.";"
		)->queryAll();

		foreach ($results_company as $result_company){
			$result_product = Yii::$app->db->createCommand(
				"SELECT * FROM `company_product` WHERE `id`= ".$result_company['company_product_id'].";"
			)->queryOne();

			if ($result_product['id'] == 10){
				$price = true;
			}
		}

		return $price;
	}

	public function getServices($order_prd_id){
		$data = [];

		$results_company = Yii::$app->db->createCommand(
			"SELECT * FROM `order_has_company_product` WHERE `order_id`= ".$order_prd_id.";"
		)->queryAll();

		foreach ($results_company as $result_company){
			$result_product = Yii::$app->db->createCommand(
				"SELECT * FROM `company_product` WHERE `id`= ".$result_company['company_product_id'].";"
			)->queryOne();

			$data[] = $result_product;
		}

		return $data;
	}


	// Nikita Mobile

	public function getUserPhone($customer_id){
		$result_user = Yii::$app->db->createCommand(
			"SELECT * FROM `user` WHERE `id`= ".$customer_id.";"
		)->queryOne();

		return $result_user['cell_phone'];
	}

	public function sendSms($phone, $text)
	{

			$envelope= '<?xml version="1.0" encoding="UTF-8"?>

            <bulk-request login="renttrans" password="renttrans" ref-id="'.date('Y-m-d H:i:s').'" delivery-notification-requested="true" version="1.0">

              <message id="2" msisdn="'.$phone.'" service-number="renttrans" defer-date="'.date('Y-m-d H:i:s').'" validity-period="3" priority="1">

               <content type="text/plain">'.$text.'</content>

              </message>

            </bulk-request>';

			$header = array(
				"Content-type:text/xml; charset=\"utf-8\"",
			);

			$MSAPI_Call = curl_init();
			//Change the following URL to point to production instead of integration
			curl_setopt($MSAPI_Call, CURLOPT_URL, 'http://31.47.195.66:80/broker/');
			curl_setopt($MSAPI_Call, CURLOPT_TIMEOUT, 30);
			curl_setopt($MSAPI_Call, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($MSAPI_Call, CURLOPT_POST, true);
			curl_setopt($MSAPI_Call, CURLOPT_POSTFIELDS, $envelope);
			curl_setopt($MSAPI_Call, CURLOPT_HTTPHEADER, $header);
			curl_setopt($MSAPI_Call, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($MSAPI_Call, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($MSAPI_Call, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

			$response = curl_exec($MSAPI_Call);
			$err = curl_error($MSAPI_Call);
			curl_close($MSAPI_Call);
			//Call Parse Function for the XML response
			$result = simplexml_load_string($response);
			$out = $this->xml2array ( $result, $out = array () );
	}

	function xml2array ($xmlObject, $out = array () )
	{
		foreach ( (array) $xmlObject as $index => $node )
		{
			$out[$index] = ( is_object ( $node ) ) ? $this->xml2array ( $node ) : $node;
		}
		return $out;
	}

	// Get ItemMark
	public function getMark($mark_id){
		$result_user = Yii::$app->db->createCommand(
			"SELECT * FROM `marka` WHERE `id`= ".$mark_id.";"
		)->queryOne();

		return $result_user['mark'];
	}
}