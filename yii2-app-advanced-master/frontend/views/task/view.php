<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $model common\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?php if ( \common\models\ProjectUser::find()
            ->byUser(Yii::$app->user->id, \common\models\ProjectUser::ROLE_MANAGER)->column()):  ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы точно хотите удалить эту задачу?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;  ?>

        <?php if ( Yii::$app->taskService->canTake(\common\models\Project::findOne($model->project_id),
            $model, Yii::$app->user->identity)):  ?>
            <?= Html::a('Взять задачу в работу', ['take', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Вы точно хотите взять эту задачу?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif;  ?>

        <?php if ( Yii::$app->taskService->canComplete($model, Yii::$app->user->identity)):  ?>
            <?= Html::a('Закончить работу над задачей', ['complete', 'id' => $model->id], [
                'class' => 'btn btn-info',
                'data' => [
                    'confirm' => 'Вы точно хотите закончить работу с этой задачей?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif;  ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'project_id',
                'format' => 'html',
                'value' => function (\common\models\Task $model) {
                    $project = \common\models\Project::findOne($model->project_id);
                    return Html::a($project->title, ['project/view', 'id' => $project->id]);
                }
            ],
            'estimation',
            [
                'attribute' => 'executor_id',
                'format' => 'html',
                'value' => function (\common\models\Task $model) {
                    $user = \common\models\User::findOne($model->executor_id);
                    if($user) {
                        return Html::a($user->username, ['user/view', 'id' => $user->id]);
                    }
                    return null;
                }

            ],
            'started_at:datetime',
            'completed_at:datetime',
            [
                'attribute' => 'created_by',
                'format' => 'html',
                'value' => function (\common\models\Task $model) {
                    $user = \common\models\User::findOne($model->created_by);
                    return Html::a($user->username, ['user/view', 'id' => $user->id]);
                }

            ],
            'created_at:datetime',
            [
                'attribute' => 'updated_by',
                'format' => 'html',
                'value' => function (\common\models\Task $model) {
                    $user = \common\models\User::findOne($model->updated_by);
                    return Html::a($user->username, ['user/view', 'id' => $user->id]);
                }

            ],

            'updated_at:datetime',
        ],
    ]) ?>

    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
        'relatedTo' => 'User ' . \Yii::$app->user->identity->username . ' commented on the page ' . \yii\helpers\Url::current(),
        'maxLevel' => 2,
        'dataProviderConfig' => [
            'pagination' => [
                'pageSize' => 10
            ],
        ],
        'listViewConfig' => [
            'emptyText' => Yii::t('app', 'No comments found.'),
        ],
    ]); ?>

</div>
