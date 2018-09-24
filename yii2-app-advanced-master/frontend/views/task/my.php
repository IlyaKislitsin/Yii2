<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 24.09.2018
 * Time: 1:25
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $managers array */
/* @var $projects array */

$this->title = 'Мои задачи';
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Мои задачи';
?>
<div class="task-my">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'title',
            'description:ntext',
            'estimation',
            [
                'attribute' => 'project_id',
                'format' => 'html',
                'filter' => $projects,
                'value' => function (\common\models\Task $model) {
                    $project = \common\models\Project::find()->where(['id' => $model->project_id])->one();
                    return Html::a($project->title, ['project/view', 'id' => $project->id]);
                }
            ],

            'started_at:datetime',
            [
                'attribute' => 'created_by',
                'format' => 'html',
                'filter' => $managers,
                'value' => function (\common\models\Task $model) {
                    $user = \common\models\User::find()->where(['id' => $model->created_by])->one();
                    return Html::a($user->username, ['user/view', 'id' => $user->id]);
                }

            ],
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Действия',
                'headerOptions' => ['style' => 'color: #337ab7'],
                'template' => "{view} {update} {delete} {complete}",
                'buttons' =>[
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
                    'complete' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canComplete($model, Yii::$app->user->identity);
                    }
                ],

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>