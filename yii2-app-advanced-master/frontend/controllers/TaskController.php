<?php

namespace frontend\controllers;

use Yii;
use common\models\Task;
use common\models\TaskSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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
                    'take' => ['POST'],
                    'complete' => ['POST'],
                ],
            ],
        ];
    }



    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 8;

        $developers = \common\models\User::find()->select('username')
            ->onlyActiveByRole(\common\models\ProjectUser::ROLE_DEVELOPER)->indexBy('id')->column();
        $managers = \common\models\User::find()->select('username')
            ->onlyActiveByRole(\common\models\ProjectUser::ROLE_MANAGER)->indexBy('id')->column();
        $projects = \common\models\Project::find()->select('title')
            ->onlyActive()->indexBy('id')->column();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'developers' => $developers,
            'managers' => $managers,
            'projects' => $projects,
        ]);
    }

    /**
     * * Lists Task models from User->identity.
     * @return mixed
     */
    public function actionMy ()
    {
        $searchModel = new TaskSearch();
        $dataProvider = New ActiveDataProvider([
            'query' => Task::find()->byUser(Yii::$app->user->id)
        ]);
        $dataProvider->pagination->pageSize = 8;

        $managers = \common\models\User::find()->select('username')
            ->onlyActiveByRole(\common\models\ProjectUser::ROLE_MANAGER)->indexBy('id')->column();

        $projects = \common\models\Project::find()->select('title')
            ->onlyActive()->indexBy('id')->column();

        return $this->render('my', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'managers' => $managers,
            'projects' => $projects,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Задача успешно создана');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $projects = \common\models\Project::find()->select('title')
            ->byUser(Yii::$app->user->id, \common\models\ProjectUser::ROLE_MANAGER)->indexBy('id')->column();


        return $this->render('create', [
            'model' => $model,
            'projects' => $projects
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Задача успешно отредактирована');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $projects = \common\models\Project::find()->select('title')
            ->byUser(Yii::$app->user->id, \common\models\ProjectUser::ROLE_MANAGER)->indexBy('id')->column();

        return $this->render('update', [
            'model' => $model,
            'projects' => $projects
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Задача успешно удалена');
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTake($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->taskService->takeTask($model, Yii::$app->user->identity)) {
            Yii::$app->session->setFlash('success', 'Задача успешно взята в работу');
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionComplete($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->taskService->completeTask($model)) {
            Yii::$app->session->setFlash('success', 'Работа с задачей успешно завершена');
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }


    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
