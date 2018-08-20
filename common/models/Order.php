<?php

namespace common\models;

use frontend\models\Chat;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $status
 * @property string $from
 * @property string $to
 * @property string $rental_price
 * @property string $service_price
 * @property string $created
 * @property string $updated
 * @property int $user_id
 * @property int $item_id
 * @property int $item_user_id
 * @property Model $model
 * @property ClassItem $class
 * @property TransmissionVehicles $transmission
 * @property TypeBody $typeBody
 * @property Category $category
 * @property string $orderId
 * @property Chat[] $chats
 * @property User $user
 * @property OrderHasCompanyProduct $orderHasCompanyProduct
 * @property CompanyProduct $companyProduct
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'user_id', 'item_id', 'item_user_id'], 'integer'],
            [['from', 'to', 'created', 'updated'], 'safe'],
            [['rental_price', 'service_price'], 'number'],
            [['user_id', 'item_id', 'item_user_id', 'orderId'], 'required'],
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
            'status' => 'Status',
            'from' => 'From',
            'to' => 'To',
            'rental_price' => 'Rental Price',
            'service_price' => 'Service Price',
            'created' => 'Created',
            'updated' => 'Updated',
            'user_id' => 'User ID',
            'item_id' => 'Item ID',
            'item_user_id' => 'Item User ID',
            'orderId' => 'Order ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['order_id' => 'id']);
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
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderHasCompanyProducts()
    {
        return $this->hasMany(OrderHasCompanyProduct::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyProducts()
    {
        return $this->hasMany(CompanyProduct::className(), ['id' => 'company_product_id'])->viaTable('order_has_company_product', ['order_id' => 'id']);
    }

}