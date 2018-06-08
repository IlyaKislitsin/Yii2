<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 08.06.2018
 * Time: 13:37
 */

namespace app\controllers;

use app\models\Product;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex() {
        $product = new Product(1, "NEW_product", "Category1", 1999);
//        return $this->renderContent("Добро пожаловать на тестовую страничку!!!");
        return $this->render('index', ['product' => $product]);
    }
}