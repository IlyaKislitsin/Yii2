<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 18.09.2018
 * Time: 22:24
 */

namespace common\components;


use common\models\ProjectUser;
use yii\base\Event;

class AssignRoleEvent extends Event
{
    public $project;
    public $user;
    public $role;

    public function showNewRole () {
        return ['project'   => function() {
            return 'id: ' . $this->project->id . ', title: ' . $this->project->title . '.';
        },
            'user'      => function() {
                return 'id: ' . $this->user->id . ', login: ' . $this->user->username . '.';
            },
            'role' => $this->role
        ];
    }
}

use common\models\Project;
use common\models\User;
use yii\base\Component;

class ProjectService extends Component
{
    const EVENT_ASSIGN_ROLE = 'assign_role';

    /**
     * @param Project $project
     * @param User $user
     * @param $role
     */
    public function assignRole(Project $project, User $user, $role)
    {
        $event = new AssignRoleEvent();
        $event->project = $project;
        $event->user = $user;
        $event->role = $role;
        $this->trigger(self::EVENT_ASSIGN_ROLE, $event);
    }

    /**
     * @param Project $project
     * @param User $user
     * @return array
     */
    public function getRoles(Project $project, User $user)
    {
        return ProjectUser::find()->select('role')
            ->andWhere(['project_id' => $project->id, 'user_id' => $user->id])->column();
    }

    /**
     * @param Project $project
     * @param User $user
     * @param $role
     * @return bool
     */
    public function hasRole(Project $project, User $user, $role)
    {
        $roles = $this->getRoles($project, $user);
        foreach($roles as $item => $value) {
            if ($roles[$item] === $role) {
                return true;
            }
        }
        return false;
    }
}