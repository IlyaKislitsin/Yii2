<?php
use yii\helpers\Html;
$user = Yii::$app->user->identity;

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $user \common\models\User */

?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <?php if(Yii::$app->user->isGuest): ?>

            <div class="pull-right">

                <?= Html::a(
                    'Login',
                    ['site/login'],
                    [
                        'class' => 'btn btn-primary btn-outline-primary',
                        'style' => 'border-color:#222d32; background-color:#367fa9; margin:8px 20px; box-sizing:border-box']
                ) ?>

            </div>

            <?php else: ?>

             <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->

                <!-- User Account: style can be found in dropdown.less -->


                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $user->getThumbUploadUrl('avatar', $user::AVATAR_SMALL)?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= $user->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $user->getThumbUploadUrl('avatar', $user::AVATAR_MEDIUM)?>" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?= $user->username ?> - Web Developer
                            </p>
                        </li>
                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(
                                    'Profile',
                                    ['/user/view', 'id' => $user->id],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>

            <?php endif; ?>

        </div>
    </nav>
</header>
