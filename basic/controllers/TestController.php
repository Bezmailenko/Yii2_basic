<?php

namespace app\controllers;

use app\components\TestService;
use app\models\LoginForm;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\web\Controller;
use app\models\Product;

class Attributes extends Model{
    public function getProp() {
        return $this->prop;
    }

    public function setProp($value) {
        $this->prop = $value;
    }
}

class TestController extends Controller {

//    public function actionIndex() {
//        return $this->renderContent('Hello Test');
//    }

    public function actionIndex() {
//        $test = \Yii::$app->test->run();
//        $model = new Product;
//        $model->id = 1;
//        $model->category = 'Phones';
//        $model->name = 'Samsung';
//        $model->price = 50000;
//
//        return $this->render('index', [
//            'var' => 'Hello Test',
//            'model' => $model,
//            'test' => $test
//        ]);
        $model = new LoginForm();
        $model->username = 'John';
        $model->password = '123';
        return VarDumper::dumpAsString($model->getAttributes, 5, true);
        return $this->render('index', [
            'model' => $model
        ]);
    }
}
