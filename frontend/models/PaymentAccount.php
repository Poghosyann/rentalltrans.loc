<?php

namespace app\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "payment_account".
 *
 * @property integer $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property integer $phone_1
 * @property integer $phone_2
 * @property string $date_of_birth
 * @property string $ssn
 * @property string $bank_account_name
 * @property string $bank_account_number
 * @property string $bank_name
 * @property string $routing_number
 * @property string $tier
 * @property string $MerchantAccountNum
 * @property string $password
 * @property string $MerchantProfileId
 * @property integer $user_id
 *
 * @property User $user
 */
class PaymentAccount extends \yii\db\ActiveRecord
{

    public $month;
    public $dey;
    public $year;
    public $checkbox;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'first_name', 'last_name', 'address_line_1', 'phone_1', 'phone_2', 'month','dey','year', 'ssn', 'bank_account_name', 'bank_account_number', 'bank_name', 'routing_number', 'user_id', 'checkbox'], 'required'],
            ['checkbox', 'compare', 'compareValue' => 1, 'operator' => '>=', 'message' => '{attribute} is required.'],
            [['user_id'], 'integer'],
            [['date_of_birth'], 'safe'],
            [['email', 'first_name', 'last_name', 'address_line_1', 'address_line_2'], 'string', 'max' => 255],
            [['phone_1', 'phone_2'], 'string', 'max' => 12],
            [['phone_1', 'phone_2'], 'string', 'min' => 10],
            [['ssn', 'routing_number'], 'string', 'max' => 9],
            [['bank_account_name'], 'string', 'max' => 32],
            [['bank_account_number'], 'string', 'max' => 25],
            [['bank_name'], 'string', 'max' => 50],
            [['tier', 'MerchantAccountNum', 'password', 'MerchantProfileId'], 'string', 'max' => 45],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['email', 'unique', 'message' => 'This email address has already been taken.'
            ],
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'address_line_1' => 'Address Line 1',
            'address_line_2' => 'Address Line 2',
            'phone_1' => 'Phone 1',
            'phone_2' => 'Phone 2',
            'date_of_birth' => 'Date Of Birth',
            'ssn' => 'Ssn',
            'bank_account_name' => 'Bank Account Name',
            'bank_account_number' => 'Bank Account Number',
            'bank_name' => 'Bank Name',
            'routing_number' => 'Routing Number',
            'tier' => 'Tier',
            'MerchantAccountNum' => 'Merchant Account Num',
            'password' => 'Password',
            'MerchantProfileId' => 'Merchant Profile ID',
            'user_id' => 'User ID',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param $email
     * @return bool
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose('paymentAccount-html',
            ['user' => $this,
            'title'      => 'Activate account',
            'htmlLayout' => 'layouts/html'])
            ->setFrom([$email => 'Rent All Trans'])
            ->setTo($this->email)
            ->setSubject('Create Payment Account ' . Yii::$app->params['siteName'])
            ->send();

    }
}
