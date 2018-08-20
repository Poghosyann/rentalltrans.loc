<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "model".
 *
 * @property integer $id
 * @property integer $mark_id
 * @property string $model
 *
 * @property Item[] $items
 * @property Marka $mark
 */
class Model extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mark_id', 'model'], 'required'],
            [['mark_id'], 'integer'],
            [['model'], 'string', 'max' => 255],
            [['mark_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marka::className(), 'targetAttribute' => ['mark_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mark_id' => 'Mark ID',
            'model' => 'Model',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['model_id' => 'id', 'mark_id' => 'mark_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMark()
    {
        return $this->hasOne(Marka::className(), ['id' => 'mark_id']);
    }
}
