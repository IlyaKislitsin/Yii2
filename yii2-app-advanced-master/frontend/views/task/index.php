<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $developers array */
/* @var $managers array */
/* @var $projects array */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if ( \common\models\ProjectUser::find()
            ->byUser(Yii::$app->user->id, \common\models\ProjectUser::ROLE_MANAGER)->column()):  ?>
        <?= Html::a('Создать задачу', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif;  ?>
        <?php if ( \common\models\ProjectUser::find()
            ->byUser(Yii::$app->user->id, \common\models\ProjectUser::ROLE_DEVELOPER)->column()):  ?>
        <?= Html::a('Мои задачи', ['task/my'], ['class' => 'btn btn-info']) ?>
        <?php endif;  ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            'description:ntext',
            [
                'attribute' => 'project_id',
                'format' => 'html',
                'filter' => $projects,
                'value' => function (\common\models\Task $model) {
                    $project = \common\models\Project::findOne($model->project_id);
                    return Html::a($project->title, ['project/view', 'id' => $project->id]);
                }
            ],
            'estimation',
            [
                'attribute' => 'executor_id',
                'format' => 'html',
                'filter' => $developers,
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
                    'filter' => $managers,
                    'value' => function (\common\models\Task $model) {
                        $user = \common\models\User::findOne($model->created_by);
                        return Html::a($user->username, ['user/view', 'id' => $user->id]);
                    }

            ],

            'created_at:datetime',
            [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=> 'Действия',
                    'headerOptions' => ['style' => 'color: #337ab7'],
                    'template' => "{view} {update} {delete} {take} {complete}",
                    'buttons' =>[
                        'take' => function ($url, \common\models\Task $model, $key) {
                            return Html::a(\yii\bootstrap\Html::icon('play'),
                                ['take', 'id' => $model->id],
                                [
                                        'title' => 'Взять задачу в работу',
                                        'data'  => [
                                            'confirm'   => 'Вы точно хотите взять эту задачу?',
                                            'method'    => 'post',
                                        ],
                                ]
                            );
                        },
                        'complete' => function ($url, \common\models\Task $model, $key) {
                            return Html::a(\yii\bootstrap\Html::icon('stop'),
                                ['complete', 'id' => $model->id],
                                [
                                        'title' => 'Закончить работу с задачей',
                                        'data'  => [
                                            'confirm'   => 'Вы точно хотите закончить работу с этой задачей?',
                                            'method'    => 'post',
                                        ],
                                ]
                            );
                        },
                    ],
                    'visibleButtons' => [
                        'update' => function (\common\models\Task $model, $key, $index) {
                            return Yii::$app->taskService->canManage(\common\models\Project::findOne($model->project_id),
                                Yii::$app->user->identity);
                        },
                        'delete' => function (\common\models\Task $model, $key, $index) {
                            return Yii::$app->taskService->canManage(\common\models\Project::findOne($model->project_id),
                                Yii::$app->user->identity);
                        },
                        'take' => function (\common\models\Task $model, $key, $index) {
                            return Yii::$app->taskService->canTake(\common\models\Project::findOne($model->project_id),
                                $model, Yii::$app->user->identity);
                        },
                        'complete' => function (\common\models\Task $model, $key, $index) {
                            return Yii::$app->taskService->canComplete($model, Yii::$app->user->identity);
                        }
                    ],

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
