<?php

namespace common\models;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "project".
 *
 * @property int $id ID
 * @property string $title Заголовок
 * @property string $description Описание
 * @property boolean $active
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property ProjectUser[] $projectUsers
 * @property array $roles
 */
class Project extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_LIST = [
        self::STATUS_INACTIVE => 'неактивен',
        self::STATUS_ACTIVE => 'активен'
    ];

    const RELATION_PROJECT_USERS = 'projectUsers';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    public function behaviors()
    {
        return [
            ['class' => TimestampBehavior::class],
            ['class' => BlameableBehavior::class],
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [self::RELATION_PROJECT_USERS]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['active'], 'boolean'],
            [['id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['active'], 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'active' => 'Состояние проекта',
            'projectUsers' => 'Участники проекта',
            'roles' => 'Мои роли в проекте',
            'created_by' => 'Кем создан',
            'updated_by' => 'Кем изменён',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения'
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::className(), ['project_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function getUserList ()
    {
        $projectUsers = $this->getProjectUsers()->select('role')->indexBy('user_id')->column();
        return $projectUsers;
    }

}
