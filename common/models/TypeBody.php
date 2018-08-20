<?php

namespace common\models;

use kotchuprik\sortable\behaviors\Sortable;
use Yii;

/**
 * This is the model class for table "type_body".
 *
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property integer $order
 * @property integer $status
 *
 * @property Item[] $items
 */
class TypeBody extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            'alias' => [
                'class' => 'common\behaviors\Alias',
                'in_attribute' => 'title',
                'out_attribute' => 'alias',
                'translit' => true
            ],
            'sortable' => [
                'class' => Sortable::className(),
                'query' => self::find(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_body';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['order', 'status'], 'integer'],
            [['alias', 'title'], 'string', 'max' => 255],
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
        return $this->hasMany(Item::className(), ['type_body_id' => 'id']);
    }
}
