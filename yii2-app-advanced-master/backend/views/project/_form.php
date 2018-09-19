<?php

use yii\helpers\Html;
use unclead\multipleinput\MultipleInput;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $users common\models\Project */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="project-form">

    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'layout' => 'horizontal'
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(\common\models\Project::STATUS_LIST) ?>

    <?php if (!($model->isNewRecord)): ?>

    <?= $form->field($model, \common\models\Project::RELATION_PROJECT_USERS)->widget(MultipleInput::className(),
        //https://github.com/unclead/yii2-multiple-input/wiki/Usage
        [   'max' => 5,
            'min' => 0,
            'enableGuessTitle'  => true,
            'addButtonPosition' => MultipleInput::POS_HEADER,
            'columns' => [
                [
                    //скрытое поле: id текущего проекта
                    'name'  => 'project_id',
                    'type'  => 'hiddenInput'  ,
                    'defaultValue' => $model->id
                ],
                [
                    'name'  => 'user_id',
                    'title' => 'Пользователь',
                    'type'  => 'dropDownList',
                    'items' => $users
                ],
                [
                    'name'  => 'role',
                    'title' => 'Роль в проекте',
                    'type'  => 'dropDownList',
                    'items' => \common\models\ProjectUser::ROLE_LIST
                ]
            ]
        ]) ?>

    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\bootstrap\ActiveForm::end(); ?>

</div>
