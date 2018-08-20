<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "order_has_company_product".
 *
 * @property integer $order_id
 * @property integer $company_product_id
 *
 * @property CompanyProduct $companyProduct
 * @property Order $order
 */
class OrderHasCompanyProduct extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_has_company_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'company_product_id'], 'required'],
            [['order_id', 'company_product_id'], 'integer'],
            [['company_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyProduct::className(), 'targetAttribute' => ['company_product_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'company_product_id' => 'Company Product ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyProduct()
    {
        return $this->hasOne(CompanyProduct::className(), ['id' => 'company_product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}