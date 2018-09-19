<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои проекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' =>  function (\common\models\Project $model) {
                    return  Html::a($model->title, ['#', ['id' => $model->id]]);
                }
            ],
            'description:ntext',
            [
                    'attribute' => 'roles',
                    'headerOptions' => [
                            'style' => 'color: #337ab7'
                            ],
                    'value' =>  function (\common\models\Project $model) {
                        return  join(', ', $model->getProjectUsers()->select('role')
                            ->andWhere(['user_id' => Yii::$app->user->id])->column());
                    }
            ],
            [   'attribute' => 'active',
                'filter'    => \common\models\Project::STATUS_LIST,
                'value' => function (\common\models\Project $model) {
                    return \common\models\Project::STATUS_LIST[$model->active] ;
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',

            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}'
            ],
        ]
    ]); ?>
    <?php Pjax::end(); ?>
</div>
