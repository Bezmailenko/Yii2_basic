<?php

namespace app\controllers;

use app\models\Task;
use app\models\User;
use Yii;
use app\models\TaskUser;
use app\models\search\TaskUserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskUserController implements the CRUD actions for TaskUser model.
 */
class TaskUserController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                    'delete' => ['post'],
                    'deleteAll' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Creates a new TaskUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $taskId
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionCreate($taskId)
    {
        $task = Task::findOne($taskId);
        if (!$task || $task->creator_id != Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }
        $model = new TaskUser();
        $model->task_id = $taskId;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Access granted');
            return $this->redirect(['task/my']);
        }

        $users = User::find()->where(['<>', 'id', Yii::$app->user->id])->
        select('username')->indexBy('id')->column();
        return $this->render('create', [
            'model' => $model,
            'users' => $users
        ]);
    }

    /**
     * Creates a new TaskUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $taskId
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDeleteAll($taskId)
    {
        $task = Task::findOne($taskId);
        if (!$task || $task->creator_id != Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $task->unlinkAll(Task::RELATION_ACCESSED_USERS, true);

            Yii::$app->session->setFlash('success', 'Access remove');
            return $this->redirect(['task/shared']);
    }

    /**
     * Deletes an existing TaskUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaskUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
