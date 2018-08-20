<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "marka".
 *
 * @property integer $id
 * @property string $mark
 *
 * @property Model[] $models
 */
class Marka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'marka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mark'], 'required'],
            [['mark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mark' => 'Mark',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModels()
    {
        return $this->hasMany(Model::className(), ['mark_id' => 'id']);
    }
}
