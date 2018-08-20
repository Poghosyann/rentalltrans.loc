<?php
namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * change email form
 */
class ChangeEmailForm extends Model
{
    public $change_email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['change_email', 'trim'],
            ['change_email', 'required', 'message' => '{attribute} is required.'],
            ['change_email', 'email'],
            ['change_email', 'string', 'max' => 255],
            ['change_email', 'validateEmail'],
        ];
    }




    /**
     * @param $attribute
     * @param $params
     */
    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findOne(['email' => $this->change_email, 'status' => User::STATUS_ACTIVE]);
            if ($user) {
                $this->addError($attribute, 'This email address has already been taken.');
            }
        }
    }


    /**
     * save Email
     */
    public function saveEmail()
    {
        if ($this->validate()) {

            Yii::$app->session->setFlash('success', 'We just sent you an email with a link to confirm your email address.');

            $user = User::findOne(Yii::$app->user->id);
            $user->change_email = $this->change_email;

            $user->save();

            return $this->sendEmail();
        }
    }

    /**
     * @return bool
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne(Yii::$app->user->id);

        if ($user) {

            if(!User::isPasswordResetTokenValid($user->activate_token)){
                $user->generateActivateToken();
            }

            if ($user->save()) {
                return Yii::$app->mailer->compose('activateEmailToken-html', ['user' => $user,
                    'title'      => 'Activate Email',
                    'htmlLayout' => 'layouts/html'])
                    ->setFrom([Yii::$app->params['adminEmail'] => 'Rent All Trans'])
                    ->setTo($user->change_email)
                    ->setSubject('Activate your email ' . Yii::$app->params['siteName'])
                    ->send();
            }
        }

        return false;
    }
}