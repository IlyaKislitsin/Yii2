<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 23.08.2018
 * Time: 17:44
 */

namespace frontend\controllers;


use yii\base\Controller;

class HelloController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}