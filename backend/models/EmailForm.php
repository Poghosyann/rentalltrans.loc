<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class EmailForm extends Model
{
    public $subject;
    public $message;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['subject', 'message'], 'required', 'message' => '{attribute} is required.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Your Name',
            'email' => 'Your Email',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email, $send_email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($send_email)
            ->setFrom([$email => 'Admin Rent All Trans'])
            ->setSubject($this->subject)
            ->setTextBody($this->message)
            ->send();
    }
}
