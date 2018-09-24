<?php

namespace common\models\query;

use common\models\ProjectUser;

/**
 * This is the ActiveQuery class for [[\common\models\ProjectUser]].
 *
 * @see \common\models\ProjectUser
 */
class ProjectUserQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $userId
     * @param null $role
     * @return $this
     */
    public function byUser($userId, $role = null)
    {
        $this->andWhere(['user_id' => $userId]);
        if ($role) {
            $this->andWhere(['role' => $role]);
        }
        return $this;
    }

    /**
     * @param $projectId
     * @return ProjectUserQuery
     */
    public function byProject($projectId)
    {
        return $this->andWhere(['project_id' => $projectId]);
    }

    /**
     * @param string $role
     * @return ProjectUserQuery
     */
    public function byRole($role)
    {
        return $this->andWhere(['role' => $role]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ProjectUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ProjectUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
