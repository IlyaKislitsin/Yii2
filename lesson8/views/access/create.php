<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Access */
/* @var $users array */

$this->title = 'Cоздать';
$this->params['breadcrumbs'][] = ['label' => 'Доступ к событиям', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
            'users' => $users,
            'model' => $model,
    ]) ?>

</div>
