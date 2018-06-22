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

        return $this->render('index', ['test' => Yii::$app->test->test]);
    }

    public function actionInsert() {

        Yii::$app->db->createCommand()->insert('user', [
            'username' => 'user_1',
            'name' => 'Александр',
            'password_hash' => '1q2w3e4r5t6y',
        ])->execute();
        Yii::$app->db->createCommand()->insert('user', [
            'username' => 'user_2',
            'name' => 'Иван',
            'password_hash' => 'q1w2e3r4t5y6',
        ])->execute();
        Yii::$app->db->createCommand()->insert('user', [
            'username' => 'user_3',
            'name' => 'Сергей',
            'password_hash' => 'zaq1xsw2cde3',
        ])->execute();
        Yii::$app->db->createCommand()->insert('user', [
            'username' => 'user_4',
            'name' => 'Евгений',
            'password_hash' => 'vfr4bgt5nhy6',
        ])->execute();
        Yii::$app->db->createCommand()->batchInsert('event', ['text', 'creator_id'], [
                ['event_1', 2],
                ['event_2', 2],
                ['event_3', 4]
            ])->execute();
        return $this->render('index');
    }

    public function actionSelect() {
        $select = (new yii\db\Query())->select('*')->from('user')
            ->where(['id' => 1]);
//            yii::$app->db->createCommand("SELECT * FROM {{user}} WHERE id=:id")
//            ->bindValue(':id', 1)
//            ->query();
        $select1 = (new yii\db\Query())->select('*')->from('user')
            ->where(['>', 'id', 1])->orderBy('name');
//            yii::$app->db->createCommand("SELECT * FROM {{user}} WHERE id>:id ORDER BY [[name]]")
//            ->bindValue(':id', 1)
//            ->queryAll();
        $select2 =(new yii\db\Query())
            ->select(['Колличество записей' => new yii\db\Expression("COUNT('id')")])
            ->from('user');
//            yii::$app->db
//            ->createCommand("SELECT COUNT([[id]]) AS 'Колличество записей' FROM {{user}} ")
//            ->queryAll();
        $select3 = (new yii\db\Query())
            ->select(['Имя пользователя' => 'user.name', 'Событие' => 'event.text',
                'Время события' => 'event.dt'])
            ->from('event')
            ->innerJoin('user', 'user.id = event.creator_id');

        yii\helpers\VarDumper::dump($select->all(), $depth = 5, $highlight = true);
        yii\helpers\VarDumper::dump($select1->all(), $depth = 5, $highlight = true);
        yii\helpers\VarDumper::dump($select2->all(), $depth = 5, $highlight = true);
        yii\helpers\VarDumper::dump($select3->all(), $depth = 5, $highlight = true);
    }
}