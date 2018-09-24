<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 10.09.2018
 * Time: 18:21
 */

namespace frontend\modules\api\models;


class Project extends \common\models\Project
{
    /**
     * @return array
     */
    public function fields()
    {
        return ['id',
                'project' => function () {
                    return 'Заголовок: ' . $this->title . '. ' . 'Описание: ' . $this->description;
                    },
                'active'];
    }

    /**
     * @return array
     */
    public function extraFields()
    {
        return [self::RELATION_PROJECT_USERS];
    }
}