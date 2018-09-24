<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 22.09.2018
 * Time: 22:10
 */

namespace common\components;


use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use yii\base\Component;

class TaskService extends Component
{
    /**
     * @param Project $project
     * @param User $user
     * @return bool
     */
    public function canManage(Project $project, User $user)
    {
        return \Yii::$app->projectService->hasRole($project, $user, ProjectUser::ROLE_MANAGER);
    }

    /**
     * @param Project $project
     * @param Task $task
     * @param User $user
     * @return bool
     */
    public function canTake(Project $project, Task $task, User $user)
    {
        return (\Yii::$app->projectService->hasRole($project, $user, ProjectUser::ROLE_DEVELOPER) && !$task->executor_id);
    }

    /**
     * @param Task $task
     * @param User $user
     * @return bool
     */
    public function canComplete(Task $task, User $user)
    {
        return ($task->executor_id === $user->id && !$task->completed_at);
    }

    /**
     * @param Task $task
     * @param User $user
     * @return bool
     */
    public function takeTask(Task $task, User $user)
    {
        $task->started_at = time();
        $task->executor_id = $user->id;
        if($task->update()) {
            return true;
        }
    }

    /**
     * @param Task $task
     * @return bool
     */
    public function completeTask(Task $task)
    {
        $task->completed_at = $_SERVER['REQUEST_TIME'];
        if($task->update()) {
            return true;
        }
    }
}