<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 02.07.2018
 * Time: 20:24
 */


use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'С открытым доступом';
$this->params['breadcrumbs'][] = ['label' => 'Мои события', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-shared">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'text:text',
            'dt',
            'users' => [
                    'label' => 'Доступ открыт пользователям:',
                    'headerOptions' => ['style' => 'color: #337ab7'],
                    'value' => function (\app\models\Event $model) {
                        $array = $model->getAccessedUsers()->select('username')->column();
//                        foreach ($array as $item){
//                            $array[] = Html::a($item, ['user/view', 'id' => \app\models\User::findOne(['username' => $item])->id]);
//                        }
                        return join($array, ', ');
                    }

            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Действия',
                'headerOptions' => ['style' => 'color: #337ab7'],
                'template' => '{view} {deleteSharedAll} ',
                'buttons' => [
                    'deleteSharedAll' => function ($url, $model, $key) {
                        return Html::a(\yii\bootstrap\Html::icon('remove'),
                            ['access/delete-shared-all', 'eventId' => $model->id],
                            [
                                    'title' => 'Удалить доступ к событию для всех пользователей',
                                    'data' => [
                                        'confirm' => 'Удалить доступ к событию?',
                                        'method' => 'post',
                                    ],

                            ]);
                    },
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>