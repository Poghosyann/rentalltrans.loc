<?php
namespace frontend\models;

use common\components\Helper;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $confirm_password;
    public $status;

    public function validateEmail($attribute, $params, $validator)
    {
        if (!in_array($this->$attribute, ['USA', 'Web'])) {
            $this->addError($attribute, 'The country must be either "USA" or "Web".');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['first_name', 'trim'],
            ['first_name', 'required', 'message' => '{attribute} is required.'],
            ['first_name', 'string', 'min' => 2, 'max' => 255],

            ['last_name', 'trim'],
            ['last_name', 'required', 'message' => '{attribute} is required.'],
            ['last_name', 'string', 'min' => 2, 'max' => 255],


            ['email', 'trim'],
            ['email', 'required', 'message' => '{attribute} is required.'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'This email address has already been taken.'
            ],
            ['password', 'required', 'message' => '{attribute} is required.'],
            ['password', 'string', 'min' => 6],

            ['confirm_password', 'required', 'message' => '{attribute} is required.'],
            ['confirm_password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password'],
        ];
    }



    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        User::deleteAll(['email' =>$this->email]);

        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

    /**
     * @param $email
     * @return bool
     */
    public function sendEmail($email)
    {
        /* @var $user User */
        $user = User::findOne([
            'email' => $this->email,
        ]);

        if ($user) {

            if(!User::isPasswordResetTokenValid($user->activate_token)){
                $user->generateActivateToken();
            }

            if ($user->save()) {
                return Yii::$app->mailer->compose('activateAccountToken-html', ['user' => $user,
                    'title'      => 'Activate account',
                    'htmlLayout' => 'layouts/html'])
                    ->setFrom([$email => 'Rent All Trans'])
                    ->setTo($this->email)
                    ->setSubject('Activate your account ' . Yii::$app->params['siteName'])
                    ->send();
            }
        }

        return false;
    }
}