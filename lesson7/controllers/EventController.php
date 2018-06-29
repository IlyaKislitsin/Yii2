<?php

namespace app\controllers;

use Yii;
use app\models\Event;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],

            'user_right' => [
                'class' => AccessControl::class,
                'only' => ['my', 'create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['my', 'create', 'update', 'delete', 'view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionMy() {
        $dataProvider = new ActiveDataProvider([
            'query' => Event::find()->byCreator(Yii::$app->user->id)
        ]);

        return $this->render('my', [
            'dataProvider' => $dataProvider
        ]);

    }

    /**
     * Lists all Event models.
     * @return mixed
     */
//    public function actionIndex()
//    {
//        $dataProvider = new ActiveDataProvider([
//            'query' => Event::find(),
//        ]);
//
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();
        $model->creator_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', 'Событие создано');
            return $this->redirect(['event/my']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->creator_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['event/my']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->creator_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $model->delete();

        Yii::$app->session->setFlash('error', 'Событие удалено');
        return $this->redirect(['event/my']);
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
