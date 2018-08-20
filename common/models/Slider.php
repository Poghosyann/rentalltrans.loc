<?php

namespace common\models;

use kotchuprik\sortable\behaviors\Sortable;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "slider".
 *
 * @property integer $id
 * @property string $text
 * @property string $image
 * @property integer $order
 * @property string $created
 * @property string $updated
 * @property string $create
 */
class Slider extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
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
        return 'slider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        if($this->isNewRecord){
            return [
                [['text'], 'string'],
                [['image'], 'required'],
                [['order', 'active'], 'integer'],
                [['created', 'updated'], 'safe'],
                [['image'], 'string', 'max' => 255],
            ];
        }else{
            return [
                [['text'], 'string'],
                [['order', 'active'], 'integer'],
                [['created', 'updated'], 'safe'],
                [['image'], 'string', 'max' => 255],
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
            'text' => 'Text',
            'image' => 'Image (2000x550px)',
            'order' => 'Order',
            'active' => 'Active',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
