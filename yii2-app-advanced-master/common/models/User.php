<?php
namespace common\models;

use mohorev\file\UploadImageBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $avatar
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @mixin UploadImageBehavior
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_LIST = [
        self::STATUS_DELETED => 'удален',
        self::STATUS_ACTIVE => 'активен'
    ];

    const SCENARIO_ADMIN_CREATE = 'admin_create';
    const SCENARIO_ADMIN_UPDATE = 'admin_update';

    const AVATAR_SMALL = 'small';
    const AVATAR_MEDIUM = 'medium';
    const AVATAR_BIG = 'big';

    const RELATION_PROJECT_USERS = 'projectUsers';

    private $password;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            ['class' => TimestampBehavior::class],
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'avatar',
                'scenarios' => [self::SCENARIO_ADMIN_CREATE, self::SCENARIO_ADMIN_UPDATE],
//                'placeholder' => '@app/modules/user/assets/images/userpic.jpg',
                'path' => '@backend/web/upload/user/{id}',
                'url' => '@web/upload/user/{id}',
                'thumbs' => [
                    'small' => ['width' => 60, 'quality' => 60],
                    'medium' => ['width' => 320, 'height' => 240],
                    'big' => ['width' => 640, 'height' => 480]
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'auth_key'], 'string'],
            [['email'], 'email'],
            [['username'], 'unique'],
            [['password'], 'string', 'min' => 6],
            [['avatar'], 'image', 'extensions' => ['jpeg', 'jpg', 'png', 'gif'], 'minSize' => 100, 'maxSize' => 1024000,
                'minWidth' => 30, 'maxWidth' => 1920, 'minHeight' => 30, 'maxHeight' => 1080,
                'notImage' => 'Используйте только изображения в качестве аватара!',
                'wrongExtension' => 'Для загрузки используйте изображения с расширениями: \'jpeg\', \'jpg\', \'png\', \'gif\'',
                'uploadRequired' => 'Файл не загружен',
                'tooBig' => 'Превышен максимальный размер файла. Для загрузки используйте изображения размером меньше 1Мб.',
                'tooSmall' => 'Маленький размер файла. Для загрузки используйте изображения размером больше 100 байт.',
                'overHeight' => 'Для загрузки используйте изображения высотой меньше 1081 пикселя.',
                'overWidth' => 'Для загрузки используйте изображения шириной меньше 1921 пикселя.'
            ],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['username', 'email', 'password'], 'required',
                'on' => self::SCENARIO_ADMIN_CREATE],
            [['username', 'email'], 'required',
                'on' => self::SCENARIO_ADMIN_UPDATE]
        ];
    }

    public function attributeLabels()
    {
        return [
            'avatar' => 'Аватар',
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'password_hash' => 'Password Hash',
            'email' => 'Электронная почта',
            'status' => 'Статус',
            'auth_key' => 'Auth Key',
            'created_at' => 'Аккаунт создан',
            'updated_at' => 'Аккаунт изменён',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if($insert) {
            $this->generateAuthKey();
        }
        return true;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        if($password) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
        $this->password = $password;
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
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::className(), ['user_id' => 'id']);
    }
}
