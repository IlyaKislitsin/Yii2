<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'projectService' => [
            'class' => \common\components\ProjectService::class,
            'on ' . \common\components\ProjectService::EVENT_ASSIGN_ROLE => function(\common\components\AssignRoleEvent $event) {
                Yii::info(\common\components\ProjectService::EVENT_ASSIGN_ROLE, 'my');
                $views = ['newRoleInTheProject'];
                $data = ['user' => $event->user, 'project' => $event->project, 'role' => $event->role];
                Yii::$app->emailService->send(
                    $event->user->email,
                    'Very important!',
                    $views,
                    $data
                );
            }
        ],
        'emailService' => [
            'class' => \common\components\EmailService::class,
        ]
    ],
    'modules' => [
        'chat' => [
            'class' => 'common\modules\chat\Module'
        ]
    ],
];
