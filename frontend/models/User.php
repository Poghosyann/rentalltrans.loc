<?php

namespace frontend\models;

use common\models\Connection;
use common\models\Item;
use common\models\SearchSave;
use common\models\State;
use Eventviva\ImageResize;
use Yii;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $image
 * @property string $email
 * @property integer $status
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $city
 * @property string $zip
 * @property string $state
 * @property integer $cell_phone
 * @property integer $other_phone
 * @property integer $state_id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $created
 * @property string $updated
 * @property string $activate_token
 * @property string $facebook_token
 * @property string $google_plus_token
 * @property string $role
 * @property integer $deleted
 * @property integer $display_type
 * @property integer $hide_items
 * @property string $hide_from
 * @property string $display_name
 * @property string $hide_to
 * @property integer $notifications_email
 * @property integer $country_id
 * @property string $change_email
 *
 * @property Chat[] $chats
 * @property Chat[] $chats0
 * @property User[] $userId1s
 * @property User[] $users
 * @property Item[] $item
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'address_line_1', 'cell_phone', 'country_id', 'city_id'], 'required',  'message' => '{attribute} is required.'],
            [['status', 'city_id', 'display_type', 'country_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['first_name', 'last_name', 'email', 'address_line_1', 'address_line_2', 'image','display_name'], 'string', 'max' => 255],
            [['cell_phone', 'other_phone',], 'string', 'max' => 12],
            [['cell_phone', 'other_phone',], 'string', 'min' => 10],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'Username',
            'email' => 'Email',
            'status' => 'Status',
            'address_line_1' => 'Address Line 1',
            'address_line_2' => 'Address Line 2',
            'cell_phone' => 'Cell Phone',
            'other_phone' => 'Other Phone',
            'state_id' => 'State ID',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'created' => 'Created',
            'updated' => 'Updated',
            'activate_token' => 'Activate Token',
            'facebook_token' => 'Facebook Token',
            'google_plus_token' => 'Google Plus Token',
            'role' => 'Role',
            'image' => 'Image',
            'country_id' => 'Countries',
            'city_id' => 'Cities',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['userId' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats0()
    {
        return $this->hasMany(Chat::className(), ['user_id2' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

}
