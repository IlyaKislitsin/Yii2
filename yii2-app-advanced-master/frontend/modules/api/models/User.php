<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 10.09.2018
 * Time: 18:21
 */

namespace frontend\modules\api\models;


class User extends \common\models\User
{
    /**
     * @return array
     */
    public function fields()
    {
        return ['id',
                'account' => function () {
                    return 'Логин : ' . $this->username . '. '
                        . 'Статус: ' . User::STATUS_LIST[$this->status];
                    },
                'email'];
    }

    /**
     * @return array
     */
    public function extraFields()
    {
        return [self::RELATION_PROJECT_USERS];
    }
}