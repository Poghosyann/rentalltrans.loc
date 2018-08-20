<?

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model{

    public $old_password;
    public $new_password;
    public $confirm_password;

    public function rules(){

        return [
            [['old_password','new_password', 'confirm_password'], 'required', 'message' => '{attribute} is required.'],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],
            ['old_password', 'validatePassword'],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findOne(Yii::$app->user->id);
            if (!$user || !$user->validatePassword($this->old_password)) {
                $this->addError($attribute, 'Incorrect old password.');
            }
        }
    }

    /**
     * change password
     */
    public function changePassword(){

        if($this->validate()){
            Yii::$app->session->setFlash('success', 'Updated.');
            $user = User::findOne(\Yii::$app->user->id);
            $user->setPassword($this->new_password);
            $user->save(true,['password_hash']);
        }
    }
}