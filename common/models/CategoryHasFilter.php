<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category_has_filter".
 *
 * @property integer $category_id
 * @property integer $filter_id
 *
 * @property Category $category
 * @property Filter $filter
 */
class CategoryHasFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_has_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'filter_id'], 'required'],
            [['category_id', 'filter_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Filter::className(), 'targetAttribute' => ['filter_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'filter_id' => 'Filter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilter()
    {
        return $this->hasOne(Filter::className(), ['id' => 'filter_id']);
    }

    /**
     * @param $category_id
     * @param $filter_id
     */
    public static function add($category_id, $filter_id){

        if(!empty($category_id)){
            foreach($category_id as $id){
                $model = new CategoryHasFilter();
                $model->category_id = $id;
                $model->filter_id = $filter_id;
                $model->save();
            }
        }
    }

    /**
     * @param $filter_id
     */
    public static function remove($filter_id){
        CategoryHasFilter::deleteAll(['filter_id' => $filter_id]);
    }
}
