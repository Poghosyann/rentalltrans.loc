<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_has_filter".
 *
 * @property integer $item_id
 * @property integer $filter_id
 *
 * @property Filter $filter
 * @property Item $item
 */
class ItemHasFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_has_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['item_id', 'filter_id'], 'required'],
            [['item_id', 'filter_id'], 'integer'],
            [['filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Filter::className(), 'targetAttribute' => ['filter_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'filter_id' => 'Filter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilter()
    {
        return $this->hasOne(Filter::className(), ['id' => 'filter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * @param $item_id
     * @param $filter_id
     */
    public static function add($filter_id,$item_id){

        if(!empty($filter_id)){
            foreach($filter_id as $id){
                $model = new ItemHasFilter();
                $model->item_id = $item_id;
                $model->filter_id = $id;
                $model->save();
            }
        }
    }

    /**
     * @param $item_id
     */
    public static function remove($item_id){
        ItemHasFilter::deleteAll(['item_id' => $item_id]);
    }
}
