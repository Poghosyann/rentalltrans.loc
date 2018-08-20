<?php
namespace common\models;

use frontend\models\Chat;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
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
 * @property integer $cell_phone
 * @property integer $other_phone
 * @property integer $state_id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $created
 * @property string $updated
 * @property string $display_name
 * @property string $activate_token
 * @property string $facebook_token
 * @property string $google_plus_token
 * @property string $role
 * @property integer $deleted
 * @property integer $hide_items
 * @property string $hide_from
 * @property string $hide_to
 * @property integer $notifications_email
 * @property integer $display_type
 * @property string $change_email
 *
 * @property Chat[] $chats
 * @property Chat[] $chats0
 * @property User[] $userId1s
 * @property User[] $users
 * @property Item[] $items
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
                'value' => new Expression('NOW()'),

            ],
            'alias' => [
                'class' => 'common\behaviors\Alias',
                'in_attribute' => 'first_name',
                'out_attribute' => 'username',
                'translit' => true
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_DELETED],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
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
            'image' => 'Image',
            'email' => 'Email',
            'status' => 'Status',
            'address_line_1' => 'Address Line 1',
            'address_line_2' => 'Address Line 2',
            'state' => 'State',
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
            'deleted' => 'Deleted',
            'hide_items' => 'Hide Items',
            'hide_from' => 'Hide From',
            'hide_to' => 'Hide To',
            'notifications_email' => 'Notifications Email',
            'change_email' => 'Change Email',
            'display_name' => 'Display Name',
            'display_type' => 'Display Type',
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

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Generates activate token
     */
    public function generateActivateToken()
    {
        $this->activate_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     *  Removes activate token
     */
    public function removeActivateToken()
    {
        $this->activate_token = null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param $email
     * @return static
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserId1s()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id1'])->viaTable('connections', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('connections', ['user_id1' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['user_id' => 'id']);
    }

}
