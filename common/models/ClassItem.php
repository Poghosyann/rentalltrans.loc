<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "class".
 *
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property integer $order
 * @property integer $status
 *
 * @property Item[] $items
 */
class ClassItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['order', 'status'], 'integer'],
            [['alias'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Alias',
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
        return $this->hasMany(Item::className(), ['class_id' => 'id']);
    }
}
