<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 28.06.2018
 * Time: 11:54
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои события';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-my">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Добавить событие', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'text:text',
            'dt',
            'created_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Действия',
                'headerOptions' => ['style' => 'color: #337ab7'],
                'template' => '{view} {update} {delete} {share}',
                'buttons' => [
                    'share' => function ($url, $model, $key) {
                        return Html::a(\yii\bootstrap\Html::icon('share'),
                            ['access/create', 'eventId' => $model->id],
                            ['title' => 'Создать доступ к событию']);
                    },
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
