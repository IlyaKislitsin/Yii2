<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 23.08.2018
 * Time: 17:51
 */

namespace backend\controllers;


use yii\base\Controller;

class HelloController extends Controller
{
    public function actionIndex ()
    {
        return $this->render('index');
    }
}