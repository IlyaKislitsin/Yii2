<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Access */

$this->title = 'Редактировать запись: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Доступ к событиям', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="access-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
