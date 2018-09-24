<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать проект', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
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
            'description:ntext',
            [   'attribute' => 'active',
                'filter'    => \common\models\Project::STATUS_LIST,
                'value' => function (\common\models\Project $model) {
                    return \common\models\Project::STATUS_LIST[$model->active] ;
                }
            ],

            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
