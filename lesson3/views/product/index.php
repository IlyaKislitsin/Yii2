<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                    'class'     => yii\grid\DataColumn::class,
                    'attribute' => 'name',
                    'value'     => function ($model) {
                        return Html::a($model->name, ['view', 'id' => $model->id] );
                    },
                    'format' => 'Html'

            ],
            'price',
            [
                'class'             => yii\grid\DataColumn::class,
                'attribute'         => 'created_at',
                'contentOptions'    => ['class' => 'small'],
                'format'            => 'Datetime'

            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
