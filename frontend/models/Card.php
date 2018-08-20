<?php
namespace frontend\models;

use yii\base\Model;

/**
 * change rent card
 */
class Card extends Model
{
    public $payment_method_type;
    public $name_on_card;
    public $card_number;
    public $expiration_month;
    public $expiration_year;
    public $cvv;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['payment_method_type', 'required', 'message' => '{attribute} is required.'],

            ['name_on_card', 'required', 'message' => '{attribute} is required.'],
            ['name_on_card', 'string', 'max' => 45],

            ['card_number', 'required', 'message' => '{attribute} is required.'],
            ['card_number', 'compare', 'compareValue' => 16, 'operator' => '>=', 'type' => 'number'],

            ['expiration_month', 'required', 'message' => '{attribute} is required.'],
            ['expiration_year', 'required', 'message' => '{attribute} is required.'],
            ['cvv', 'required', 'message' => '{attribute} is required.'],

        ];
    }

}


