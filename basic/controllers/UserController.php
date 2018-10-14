<?php

namespace app\controllers;

use app\models\User;
use yii\web\Controller;



class UserController extends Controller {


    public function actionTest()
    {
        //a)
        $model = new User();
        $model->username = 'First';
        $model->name = 'Первый';
        $model->password_hash = '3049fkj209rj203';
        $model->created_at = time();
        $model->creator_id = 1;

        $model->save();

        //б)
        $models =  User::find()->innerJoinWith(User::RELATION_TASKS_CREATED)->all();

        //в)
//        $models =  User::find()->with(User::RELATION_TASKS_CREATED)->all();

        return $models;
    }

    public function actionIndex() {
        $result = $this->actionTest();
        return $this->render('index', [
            'result' => $result
        ]);
    }
}