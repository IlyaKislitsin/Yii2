<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 10.09.2018
 * Time: 19:26
 */

namespace frontend\modules\api\controllers;

use frontend\modules\api\models\Project;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class ProjectController extends Controller
{
    /**
     * @return ActiveDataProvider
     */
    public function actionIndex ()
    {
        $dataProvider = new ActiveDataProvider(['query' => Project::find()]);
        return $dataProvider;
    }

    /**
     * @param $id
     * @return array|\common\models\Project|Project|null
     */
    public function actionView ($id)
    {
        return Project::find()->where(['id' => $id])->one();
    }
}