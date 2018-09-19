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
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

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
