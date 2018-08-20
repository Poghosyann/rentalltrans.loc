<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transmission_vehicles".
 *
 * @property integer $id
 * @property string $title
 * @property integer $order
 * @property integer $status
 *
 * @property Item[] $items
 */
class TransmissionVehicles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transmission_vehicles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['order', 'status'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'order' => 'Order',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['transmission_vehicles_id' => 'id']);
    }
}
