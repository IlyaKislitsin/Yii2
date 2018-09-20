<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 19.09.2018
 * Time: 19:18
 */

/**
 * @var $user common\models\User
 * @var $project common\models\Project
 * @var $role
 */
?>

<div>
    <h1>NEW ROLE IN THE PROJECT!</h1>>
    <p>Hello, <?= \yii\helpers\Html::encode($user->username)?> !!!</p>>
    <p> You got a new role <?= $role?> in the project <?= $project->title ?></p>
</div>