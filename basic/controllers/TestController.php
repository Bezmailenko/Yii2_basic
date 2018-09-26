<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Product;

class TestController extends Controller {

//    public function actionIndex() {
//        return $this->renderContent('Hello Test');
//    }

    public function actionIndex() {
        $model = new Product;
        $model->id = 1;
        $model->category = 'Phones';
        $model->name = 'Samsung';
        $model->price = 50000;

        return $this->render('index', [
            'var' => 'Hello Test',
            'model' => $model
        ]);
    }
}
