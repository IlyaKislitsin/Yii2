<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($model->id === Yii::$app->user->id): ?>
    <p>
        <?= Html::a('Редактировать', ['profile', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php endif; ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'avatar',
                'format'    => 'image',
                'value'     => function (\common\models\User $model) {
                    return  $model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_MEDIUM);
                }
            ],
            'id',
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => \common\models\User::STATUS_LIST[$model->status]
            ],
            'created_at:datetime',
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
