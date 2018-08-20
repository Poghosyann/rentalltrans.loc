<?php

namespace common\models;

use himiklab\sitemap\behaviors\SitemapBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $alias
 * @property int $category_id
 * @property int $user_id
 * @property int $model_id
 * @property int $mark_id
 * @property int $class_id
 * @property int $type_body_id
 * @property int $transmission_vehicles_id
 * @property int $year_manufacture
 * @property int $quantity_doors
 * @property string $steering_wheel
 * @property string $description
 * @property string $price_daily
 * @property string $price_3_days
 * @property string $price_weekly
 * @property string $car_price
 * @property string $created
 * @property string $updated
 * @property string $status
 * @property int $publish
 * @property int $deleted
 * @property int $country_id
 * @property int $city_id
 * @property string $deposit
 * @property string $image_main
 * @property int $insurance
 *
 * @property Image[] $images
 * @property Category $category
 * @property City $city
 * @property Class $class
 * @property Model $model
 * @property TransmissionVehicles $transmissionVehicles
 * @property TypeBody $typeBody
 * @property User $user
 * @property ItemHasFilter[] $itemHasFilters
 * @property Filter[] $filters
 */
class Item extends \yii\db\ActiveRecord
{

    public $image;
    public $username;

    public function behaviors()
    {
        return [
            'sitemap' => [
                'class' => SitemapBehavior::className(),
                'dataClosure' => function ($model) {
                    /** @var self $model */
                    return array(
                        'loc' => Url::to('/item/'.$model->alias, true),
                        'lastmod' => strtotime("now"),
                        'changefreq' => SitemapBehavior::CHANGEFREQ_WEEKLY,
                        'priority' => 0.9
                    );
                }
            ],
            'alias' => [
                'class' => 'common\behaviors\Alias',
                'in_attribute' => 'id',
                'out_attribute' => 'alias',
                'translit' => true
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
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'user_id', 'year_manufacture', 'price_daily', 'country_id', 'city_id', 'class_id', 'mark_id', 'quantity_doors','type_body_id', 'model_id','transmission_vehicles_id', 'steering_wheel'], 'required'],
            [['category_id', 'user_id', 'model_id', 'mark_id', 'class_id', 'type_body_id', 'transmission_vehicles_id', 'year_manufacture', 'quantity_doors', 'publish', 'deleted', 'country_id', 'city_id', 'insurance'], 'integer'],
            [['description'], 'string'],
            [['price_daily', 'price_3_days', 'price_weekly', 'car_price', 'deposit'], 'number'],
            [['created', 'updated'], 'safe'],
            [['alias', 'image_main'], 'string', 'max' => 255],
            [['steering_wheel', 'status'], 'string', 'max' => 45],
            [['alias'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id', 'country_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id', 'country_id' => 'country_id']],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClassItem::className(), 'targetAttribute' => ['class_id' => 'id']],
            [['model_id', 'mark_id'], 'exist', 'skipOnError' => true, 'targetClass' => Model::className(), 'targetAttribute' => ['model_id' => 'id', 'mark_id' => 'mark_id']],
            [['transmission_vehicles_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransmissionVehicles::className(), 'targetAttribute' => ['transmission_vehicles_id' => 'id']],
            [['type_body_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypeBody::className(), 'targetAttribute' => ['type_body_id' => 'id']],
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
            'alias' => 'Alias',
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
            'model_id' => 'Model ID',
            'mark_id' => 'Mark ID',
            'class_id' => 'Class ID',
            'type_body_id' => 'Type Body ID',
            'transmission_vehicles_id' => 'Transmission Vehicles ID',
            'year_manufacture' => 'Year Manufacture',
            'quantity_doors' => 'Quantity Doors',
            'steering_wheel' => 'Steering Wheel',
            'description' => 'Description',
            'price_daily' => 'Price Daily',
            'price_3_days' => 'Price 3 Days',
            'price_weekly' => 'Price Weekly',
            'car_price' => 'Car Price',
            'created' => 'Created',
            'updated' => 'Updated',
            'status' => 'Status',
            'publish' => 'Publish',
            'deleted' => 'Deleted',
            'country_id' => 'Country ID',
            'city_id' => 'City ID',
            'deposit' => 'Deposit',
            'category.title' => 'Categories',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['item_id' => 'id']);
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
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id', 'country_id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(ClassItem::className(), ['id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Model::className(), ['id' => 'model_id', 'mark_id' => 'mark_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransmissionVehicles()
    {
        return $this->hasOne(TransmissionVehicles::className(), ['id' => 'transmission_vehicles_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeBody()
    {
        return $this->hasOne(TypeBody::className(), ['id' => 'type_body_id']);
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
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['item_id' => 'id'])->orderBy(['order.id'=>SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemHasFilters()
    {
        return $this->hasMany(ItemHasFilter::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilters()
    {
        return $this->hasMany(Filter::className(), ['id' => 'filter_id'])->viaTable('item_has_filter', ['item_id' => 'id']);
    }
}