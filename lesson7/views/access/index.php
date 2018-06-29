<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Доступ к событиям';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Создать доступ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'event_id',
            'user_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Действия',
                'headerOptions' => ['style' => 'color: #337ab7'],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
