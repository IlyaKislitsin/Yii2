<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id ID пользователя
 * @property string $username Логин
 * @property string $name Имя
 * @property string $surname Фамилия
 * @property string $password_hash hash пароля
 * @property string $access_token
 * @property string $auth_key
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Access[] $accesses
 * @property Event[] $events
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    const RELATION_EVENTS = 'events';

    /** @var $password int string пароль*/
    public $password;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['username', 'name', 'surname', 'password', 'password_hash', 'access_token', 'auth_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'password' => 'Пароль',
            'password_hash' => 'Password Hash',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
          TimestampBehavior::class
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccesses()
    {
        return $this->hasMany(Access::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['creator_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UserQuery(get_called_class());
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function beforeSave($insert)
    {


        if (parent::beforeSave($insert)) {


            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }

            if($this->password) {
                $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            return true;
        }

        return false;


    }

    public function validatePassword ($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);

    }

    public static function findByUsername($name)
    {
        return User::findOne(['username' => $name]);
    }

}
