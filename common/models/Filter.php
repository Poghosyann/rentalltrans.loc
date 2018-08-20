<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "filter".
 *
 * @property integer $id
 * @property string $title
 *
 * @property CategoryHasFilter[] $categoryHasFilters
 * @property Category[] $categories
 * @property ItemHasFilter[] $itemHasFilters
 * @property Item[] $items
 */
class Filter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryHasFilters()
    {
        return $this->hasMany(CategoryHasFilter::className(), ['filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('category_has_filter', ['filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemHasFilters()
    {
        return $this->hasMany(ItemHasFilter::className(), ['filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id' => 'item_id'])->viaTable('item_has_filter', ['filter_id' => 'id']);
    }
}
