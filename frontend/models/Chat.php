<?php

namespace frontend\models;

use app\models\Order;
use common\components\Helper;
use DateTime;
use Yii;
use yii\helpers\StringHelper;
use yii\web\NotFoundHttpException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property string $message
 * @property string $updateDate
 * @property integer $userId
 * @property integer $user_id2
 * @property string $type
 * @property string $status
 * @property integer $order_id
 *
 * @property Order $order
 * @property User $user
 * @property User $userId2
 */
class Chat extends ActiveRecord {

    public $userModel;
    public $userField;
    public $base_url;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'chat';
    }

    /**
     * @inheritdoc
     */

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['updateDate'], 'safe'],
            [['userId', 'user_id2', 'message'], 'required'],
            [['userId', 'user_id2', 'order_id'], 'integer'],
            [['type', 'status'], 'string', 'max' => 45],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['user_id2'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id2' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    public function getUser() {
        if (isset($this->userModel))
            return $this->hasOne($this->userModel, ['id' => 'userId']);
        else
            return $this->hasOne(Yii::$app->getUser()->identityClass, ['id' => 'userId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserId2()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id2']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'userId' => 'User',
            'updateDate' => 'Update Date',
        ];
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function data($id, $order_id) {

        $messages = [];
        $models1 = static::find()->where(['userId' => Yii::$app->user->id, 'user_id2' => $id])->limit(10)->orderBy(['id' => SORT_DESC])->all();
        $models2 = static::find()->where(['user_id2' => Yii::$app->user->id, 'userId' => $id])->limit(10)->orderBy(['id' => SORT_DESC])->all();

        foreach ($models1 as $model){
            if ($model->user->display_type == 1){
                $username1 = $model->user->first_name .' '. $model->user->last_name[0];
            }elseif($model->user->display_type == 2){
                $username1 = $model->user->first_name .' '. $model->user->last_name;
            }elseif ($model->user->display_type == 3){
                $username1 =   $model->user->display_name;
            }

            $date = new DateTime($model['updateDate']);
            $messages[$model['user_id2'] .'-'.$model['userId'].'-'.$model['order_id']][$date->format('Y-m-d')][$model['id']] =
                [
                    'message' => $model['message'],
                    'updateDate' => $model['updateDate'],
                    'user' => [
                        'id' => $model['userId'],
                        'alias' => $model->user->username,
                        'username' => $username1,
                        'image' => !empty($model->user->image) ? '/uploads/users/115-115/'.$model->user->image : '/images/default.jpg',
                    ],
                    'status' => $model['status'],
                    'class' =>  Yii::$app->user->id == $model->user->id ? 'in' : 'out',
                ];
        }

        foreach ($models2 as $model){
            if ($model->user->display_type == 1){
                $username1 = $model->user->first_name .' '. $model->user->last_name[0];
            }elseif($model->user->display_type == 2){
                $username1 = $model->user->first_name .' '. $model->user->last_name;
            }elseif ($model->user->display_type == 3){
                $username1 =   $model->user->display_name;
            }

            $date = new DateTime($model['updateDate']);

            $messages[$model['userId'].'-'.$model['user_id2'].'-'.$model['order_id']][$date->format('Y-m-d')][$model['id']] =
                [
                    'message' => $model['message'],
                    'updateDate' => $model['updateDate'],

                    'user' => [
                        'id' => $model['userId'],
                        'alias' => $model->user->username,
                        'username' => $username1,
                        'image' => !empty($model->user->image) ? '/uploads/users/115-115/'.$model->user->image : '/images/default.jpg',
                    ],
                    'status' => $model['status'],
                    'class' =>  Yii::$app->user->id == $model->user->id ? 'in' : 'out',
                ];
        }

        $output = '';

        $date_d = $messages[$id.'-'.Yii::$app->user->id.'-'.$order_id];
        ksort($date_d);
        if ($date_d)
            foreach ($date_d as $k => $model) {
                $date = new DateTime($k);

                $output .= '<li class="text-center chat-date">'.$date->format('d M, Y').'</li>';
                ksort($model);
                foreach ($model as $chat){

                    if (Yii::$app->user->id == $chat['user']['id']){
                        $link = '/user/my-items?status=available';
                    }else{
                        $link = '/user/'.$chat['user']['alias'].'/rental-items';
                    }

                    $output .= '<li class= "'.$chat['class'].'">
                            <a target="_blank" href="'.$link.'"><img class="avatar" alt="" src="'. $chat['user']['image'] .'"></a>
                             <div class="message">
                                <span class="arrow"></span>

                                <a target="_blank" href="'.$link.'" class="name"> ' . $chat['user']['username'] . '</a>
                                <br>
                                <span class="datetime"> '.Helper::timeElapsed($chat['updateDate']).' </span>

                               <span class="body">' . $chat['message']. '</span>
                            </div>
                        </li>';
                }
            }

        return $output;
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function chatUser($day = 7) {

        $user_data = Yii::$app->session->get('chat-user');
        $day = $user_data['dey'] ?? $day;
        $messages = [];
        $models1 = static::find()->where(['userId' => Yii::$app->user->id]);

        if($day == 'unread'){
            $models1 = $models1->andWhere(['status' => $day]);
        }elseif($day == 'last'){
	        $models1 = $models1->limit(0);
        }elseif($day != 'all'){
	        $models1 = $models1->andWhere("DATE(updateDate) > (NOW() - INTERVAL $day DAY)");
        }

        $models2 = static::find()->where(['user_id2' => Yii::$app->user->id]);

        if($day == 'unread'){
            $models2 = $models2->andWhere(['status' => $day]);
        }elseif($day == 'last'){
	        $models2 = $models2->limit(1);
        }elseif($day != 'all'){
	        $models2 = $models2->andWhere("DATE(updateDate) > (NOW() - INTERVAL $day DAY)");
        }

        $models2 = $models2->orderBy(['id' => SORT_DESC])->all();
        $models1 = $models1->orderBy(['id' => SORT_DESC])->all();

        $output = '';

        foreach ($models1 as $model){
            if ($model->userId2->display_type == 1){
                $username1 = $model->userId2->first_name .' '. $model->userId2->last_name[0];
            }elseif($model->userId2->display_type == 2){
                $username1 = $model->userId2->first_name .' '. $model->userId2->last_name;
            }elseif ($model->userId2->display_type == 3){
                $username1 =   $model->userId2->display_name;
            }

            if($model->order->id){
                $message = 'Sent a rental request';
            }

            $messages[$model->order->id ? $model->order->id: $model->userId2] =
                [
                    'id' => $model['user_id2'],
                    'username' => $username1,
                    'image' => $model->userId2->image ? '/uploads/users/115-115/'.$model->userId2->image : '/images/default.jpg',
                    'message' => $message,
                    'url' => $model->order->id ? '/messages/'.$model->userId2->username.'?order_id='.$model->order->id : '/messages/'.$model->userId2->username,
                    'class' => Chat::find()->where(['status' => 'unread','user_id2' => $model->userId, 'userId' => Yii::$app->user->id])->count() ? 'active' : '',
                    'rent' => $model->order->id ? 'request-item' : '',
                ];
       }

        foreach ($models2 as $model){
            if ($model->user->display_type == 1){
                $username1 = $model->user->first_name .' '. $model->user->last_name[0];
            }elseif($model->user->display_type == 2){
                $username1 = $model->user->first_name .' '. $model->user->last_name;
            }elseif ($model->user->display_type == 3){
                $username1 =   $model->user->display_name;
            }

            if($model->order->id){
                $message = 'Sent a rental request';
            }

            $messages[$model->order->id ? $model->order->id: $model->userId] =
                [
                    'id' => $model->userId,
                    'username' => $username1,
                    'image' => $model->user->image ? '/uploads/users/115-115/'.$model->user->image : '/images/default.jpg',
                    'message' => $message,
                    'url' => $model->order->id ? '/messages/'.$model->user->username.'?order_id='.$model->order->id : '/messages/'.$model->user->username,
                    'class' => Chat::find()->where(['status' => 'unread','userId' => $model->userId, 'user_id2' => Yii::$app->user->id])->count() ? 'active' : '',
                    'rent' => $model->order->id ? 'request-item' : '',
                ];
        }

        if ($messages){
            foreach ($messages as $chat_user) {
                if($chat_user->id != Yii::$app->user->id){
                    $output .=                    '
                       <a style="text-decoration: none" href= "'.$chat_user['url'].'">
                            <li class="queue-vid media '.$chat_user['class'].'">
                                <img class="media-object" src="'. $chat_user['image'].'">
                                <div class="media-body vid-desc">
                                    <h4 class="media-heading name">
                                      '.$chat_user['username'].'
                                    </h4>
                                    <div class="media-heading-sub hidden-sm '.$chat_user['rent'].' ">'
                                    .$chat_user['message'].
                                    '</div>
                                </div>
                            </li>
                        </a>
                    ';
                }
            }
        }

        return $output;
    }

}
?>