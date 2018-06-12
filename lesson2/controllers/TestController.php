<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 08.06.2018
 * Time: 13:37
 */

namespace app\controllers;

//use app\components\TestService;

use yii;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex() {

        return $this->render('index', ['test' => Yii::$app->test->getTest()]);
    }
}