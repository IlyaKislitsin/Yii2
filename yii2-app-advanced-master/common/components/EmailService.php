<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 12.09.2018
 * Time: 20:07
 */

namespace common\components;

use yii;


class EmailService extends yii\base\Component
{
    public function send($to, $subject, $views, $data)
    {
        return Yii::$app
            ->mailer
            ->compose($views, $data)
            // $views - представление для отрисовки тела сообщения, $data -  параметры , которые будут доступны в файле
            // представления.
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($to)
            // $to - email
            ->setSubject($subject)
            // $subject - сообщение(объект)
            ->send();
    }
}