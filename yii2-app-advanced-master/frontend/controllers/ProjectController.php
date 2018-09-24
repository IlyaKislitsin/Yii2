<?php

namespace frontend\controllers;

use common\models\User;
use common\models\ProjectSearch;
use Yii;
use common\models\Project;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();

        $dataProvider = new ActiveDataProvider([
            'query' => Project::find()->byUser(Yii::$app->user->id)
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $query = $model->getProjectUsers()
            ->select('user_id')->indexBy('user_id')->column();
        $users = User::find()->select('username')
            ->andWhere(['id' => $query])->column();

        return $this->render('view', [
            'model' => $model,
            'users' => $users
        ]);
    }

//    public function actionTest()
//    {
//        return VarDumper::dumpAsString(Yii::$app->taskService->canComplete(
//            Task::findOne(1),
//            User::findOne(3)),
//            10, true);
//        return VarDumper::dumpAsString($project = \common\models\Project::find()->select('title')
//            ->andWhere(['id' => 1])->column(), 10, true);
//
//    }


    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
