<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 04.07.2018
 * Time: 20:01
 */


use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'События пользователей, доступные мне';
$this->params['breadcrumbs'][] = ['label' => 'Мои события', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-accessed">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'text:text',
            [
                    'label' => 'Пользователь',
                    'value' => 'creator.username',
                    'headerOptions' => ['style' => 'color: #337ab7'],
            ],
            'dt',
            'created_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Действия',
                'headerOptions' => ['style' => 'color: #337ab7'],
                'template' => '{view}',
//                'buttons' => [
//                    'deleteSharedAll' => function ($url, $model, $key) {
//                        return Html::a(\yii\bootstrap\Html::icon('remove'),
//                            ['access/delete-shared-all', 'eventId' => $model->id],
//                            [
//                                    'title' => 'Удалить доступ к событию для всех пользователей',
//                                    'data' => [
//                                        'confirm' => 'Удалить доступ к событию?',
//                                        'method' => 'post',
//                                    ],
//
//                            ]);
//                    },
//                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>