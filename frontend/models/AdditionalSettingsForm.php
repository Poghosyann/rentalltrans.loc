<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 3/28/2017
 * Time: 5:57 PM
 */

namespace frontend\models;

use phpDocumentor\Reflection\Types\Null_;
use Yii;
use yii\base\Model;
use common\models\User;

class AdditionalSettingsForm extends Model
{

    public $notifications_email;

    public function rules()
    {

        return [
            [['notifications_email'], 'integer'],
        ];
    }

    /**
     * notifications Email
     */
    public function notificationsEmail(){

        if($this->validate()){
            Yii::$app->session->setFlash('success', 'Updated.');

            $user = User::findOne(Yii::$app->user->id);
            $user->notifications_email = $this->notifications_email;

            return $user->save();
        }
    }
}