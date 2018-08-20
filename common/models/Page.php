<?php

namespace common\models;

use himiklab\sitemap\behaviors\SitemapBehavior;
use kotchuprik\sortable\behaviors\Sortable;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $order
 * @property string $created
 * @property string $updated
 *
 * @property Team[] $teams
 */
class Page extends \yii\db\ActiveRecord
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
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description', 'meta_description'], 'string'],
            [['order', 'footer_menu'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['alias', 'title', 'meta_title', 'meta_keywords'], 'string', 'max' => 255],
            [['alias'], 'unique'],
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
            'description' => 'Description',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'order' => 'Order',
            'image' => 'Image (2000 X 400)',
            'footer_menu' => 'Footer Menu',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeams()
    {
        return $this->hasMany(Team::className(), ['page_id' => 'id']);
    }
}
