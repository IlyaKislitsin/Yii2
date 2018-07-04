<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 08.06.2018
 * Time: 13:55
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $test app\controllers\TestController */

$this->title = 'Тестовая страничка, написанная на Yii2!!!';
?>

<div class="test-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <h3>
        Это результат выполнения метода TestService:
        <?= Html::tag('mark', Html::encode($test)) ?>
    </h3>

</div>
