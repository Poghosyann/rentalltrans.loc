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

class PersonalInformationForm extends Model
{

    public $hide_items;
    public $from;
    public $to;

    public function rules()
    {

        return [
            [['hide_items'], 'integer'],
            [['from', 'to'], 'safe'],
        ];
    }

    /**
     * change password
     */
    public function personalInformation(){

        if($this->validate()){
            Yii::$app->session->setFlash('success', 'Updated.');
            $user = User::findOne(Yii::$app->user->id);


            if($this->hide_items){
                $user->hide_from = $this->from ? Yii::$app->formatter->asDate($this->from, 'php:Y-m-d') : null;
                $user->hide_to = $this->to ? Yii::$app->formatter->asDate($this->to, 'php:Y-m-d') : null;
                if($this->from){
                    $user->hide_items = Yii::$app->formatter->asDate($this->from, 'php:Y-m-d') == Yii::$app->formatter->asDate('now', 'php:Y-m-d') ? 1 : 0;
                }else{
                    $user->hide_items = $this->hide_items;
                }
            }else{
                $user->hide_from = null;
                $user->hide_to = null;
                $user->hide_items = 0;
            }

            return $user->save();
        }
    }
}