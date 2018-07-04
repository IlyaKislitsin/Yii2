<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Event]].
 *
 * @see \app\models\Event
 */
class EventQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Event[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Event|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * public function byCreator()
     * @param integer $userId
     * @return mixed
     */
    public function byCreator($userId) {
        return $this->andWhere(['creator_id' => $userId]);
    }
}
