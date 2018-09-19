<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="user-form">

    <?php $form = \yii\bootstrap\ActiveForm::begin([
            'layout' => 'horizontal'
    ]); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'status')->dropDownList(\common\models\User::STATUS_LIST) ?>
    <?= $form->field($model, 'avatar')->fileInput()
        ->label(\yii\bootstrap\Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_SMALL))) ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\bootstrap\ActiveForm::end(); ?>

</div>
