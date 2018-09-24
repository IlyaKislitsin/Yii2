<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $users array */


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'projectUsers',
                'value' =>  join(', ', $users)
            ],
            [
                'attribute' => 'roles',
                'headerOptions' => [
                    'style' => 'color: #337ab7'
                ],
                'value' =>  function (\common\models\Project $model) {
                    return  join(', ', Yii::$app->projectService->getRoles(
                        $model, Yii::$app->user->identity));
                }
            ],
            [
                'attribute' => 'active',
                'value'     => \common\models\Project::STATUS_LIST[$model->active]
            ],
            [
                'attribute' => 'created_by',
                'value'     => function (\common\models\Project $model) {
                    $user = \common\models\User::findOne($model->created_by);
                    return  $user->username;
                }
            ],
            'created_at:datetime',
            [
                'attribute' => 'updated_by',
                'value'     => function (\common\models\Project $model) {
                    $user = \common\models\User::findOne($model->updated_by);
                    return  $user->username;
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
