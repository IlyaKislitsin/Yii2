<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 22.09.2018
 * Time: 19:28
 */

namespace common\models\query;

use common\models\ProjectUser;
use common\models\User;

/**
 * This is the ActiveQuery class for [[\common\models\User]].
 *
 * @see \common\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /**
     * @return UserQuery
     */
    public function onlyActive()
    {
        return $this->andWhere(['status' => User::STATUS_ACTIVE]);
    }

    /**
     * @param string $role
     * @return UserQuery
     */
    public function onlyActiveByRole($role) {
        $query = ProjectUser::find()->select('user_id')->byRole($role);
        return $this->onlyActive()->andWhere(['id' => $query]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}