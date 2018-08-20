<?php

namespace common\models;

use common\components\Helper;
use himiklab\sitemap\behaviors\SitemapBehavior;
use kotchuprik\sortable\behaviors\Sortable;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property string $icon
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $order
 * @property string $created
 * @property string $updated
 * @property integer $status
 * @property integer $add_item
 *
 * @property CategoryHasFilter[] $categoryHasFilters
 * @property Filter[] $filters
 * @property Item[] $items
 */
class Category extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            'sitemap' => [
                'class' => SitemapBehavior::className(),
                'dataClosure' => function ($model) {
                    /** @var self $model */
                    return array(
                        'loc' => Url::to('/category/'.$model->alias, true),
                        'lastmod' => strtotime("now"),
                        'changefreq' => SitemapBehavior::CHANGEFREQ_WEEKLY,
                        'priority' => 0.9
                    );
                }
            ],
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
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {

        if($this->isNewRecord){
            return [
                [['title', 'icon'], 'required'],
                [['meta_description'], 'string'],
                [['order', 'status','add_item'], 'integer'],
                [['created', 'updated'], 'safe'],
                [['alias', 'title', 'icon', 'meta_title', 'meta_keywords'], 'string', 'max' => 255],
                [['alias'], 'unique'],
            ];
        }else{
            return [
                [['title'], 'required'],
                [['meta_description'], 'string'],
                [['order', 'status', 'add_item'], 'integer'],
                [['created', 'updated'], 'safe'],
                [['alias', 'title', 'icon', 'meta_title', 'meta_keywords'], 'string', 'max' => 255],
                [['alias'], 'unique'],
            ];
        }

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
            'icon' => 'Icon',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'order' => 'Order',
            'created' => 'Created',
            'updated' => 'Updated',
            'status' => 'Status',
            'add_item' => 'Add',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        $item = $this->hasMany(Item::className(), ['category_id' => 'id'])
            ->leftJoin('user', 'item.user_id = user.id')
            ->where(['user.status' => User::STATUS_ACTIVE, 'user.hide_items' => 0, 'item.status' => 'Available', 'item.deleted' => 0]);

        return $item;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSearchSaves()
    {
        return $this->hasMany(SearchSave::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryHasFilters()
    {
        return $this->hasMany(CategoryHasFilter::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilters()
    {
        return $this->hasMany(Filter::className(), ['id' => 'filter_id'])->viaTable('category_has_filter', ['category_id' => 'id']);
    }

}
