<?php

namespace app\controllers;

use app\models\Event;
use app\models\User;
use Yii;
use app\models\Access;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\query\UserQuery;
use yii\filters\AccessControl;

/**
 * AccessController implements the CRUD actions for Access model.
 */
class AccessController extends Controller
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
                    'delete-shared-all' =>['POST']
                ],
            ],

            'user_right' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'update', 'delete', 'view'],
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


    /**
     * Creates a new Access model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($eventId)
    {
        $event = Event::findOne($eventId);
        if(!$event){
            throw new NotFoundHttpException();
        }
        if($event->creator_id !== Yii::$app->user->id ) {
            throw new ForbiddenHttpException();
        }
        $model = new Access();
        $model->event_id = $eventId;
        $users = User::find()->excludeUser(Yii::$app->user->id)
            ->select('username')
            ->indexBy('id')
            ->column();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', 'Доступ к событию создан');
            return $this->redirect(['event/shared']);
        }

        return $this->render('create', [
            'users' => $users,
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Access model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteSharedAll($eventId)
    {
        $event = Event::findOne($eventId);
        if(!$event){
            throw new NotFoundHttpException();
        }
        if($event->creator_id !== Yii::$app->user->id ) {
            throw new ForbiddenHttpException();
        }

        $event->unlinkAll(Event::RELATION_ACCESSED_USERS, true);

        Yii::$app->session->setFlash('error', 'Доступ к событию удален');
        return $this->redirect(['event/shared']);
    }

    /**
     * Finds the Access model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Access the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Access::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
