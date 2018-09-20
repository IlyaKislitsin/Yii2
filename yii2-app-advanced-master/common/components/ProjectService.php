<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 18.09.2018
 * Time: 22:24
 */

namespace common\components;


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

    public function assignRole(Project $project, User $user, $role)
    {
        $event = new AssignRoleEvent();
        $event->project = $project;
        $event->user = $user;
        $event->role = $role;
        $this->trigger(self::EVENT_ASSIGN_ROLE, $event);
    }
}