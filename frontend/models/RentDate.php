<?php
namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * change rent now
 */
class RentDate extends Model
{
    public $from;
    public $to;

    public $from_h;
    public $from_i;
    public $to_h;
    public $to_i;
    public $categories;
    public $from_location;
    public $to_location;

    public $price;
    public $user;
    public $class;
    public $marka;
    public $model;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['from', 'required', 'message' => '{attribute} is required.'],
            ['to', 'required', 'message' => '{attribute} is required.'],
            ['from_location', 'required', 'message' => '{attribute} is required.'],
            ['categories', 'required', 'message' => '{attribute} is required.'],
            ['to_location', 'required', 'message' => '{attribute} is required.'],

        ];
    }

}