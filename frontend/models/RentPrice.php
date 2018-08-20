<?php
namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * change rent now
 */
class RentPrice extends Model
{
    public $checkbox;
    public $additional;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['checkbox', 'integer', 'min' => 1, 'message' => '{attribute} is required.'],
            [['additional'], 'integer'],
        ];
    }
}