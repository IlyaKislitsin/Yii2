<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 23.08.2018
 * Time: 18:08
 */

namespace console\controllers;


use yii\console\Controller;

class ConsoleGreatingsController extends Controller
{
    /**
     * Hello, world!!!
     */
    public function actionIndex () {
        echo 'Hello, world!!!' . PHP_EOL;
    }
}