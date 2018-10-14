<?php

namespace app\controllers;

use app\components\TestService;
use app\models\LoginForm;
use yii\base\BaseObject;
use yii\base\Model;
use yii\db\Query;
use yii\helpers\VarDumper;
use yii\web\Controller;
use app\models\Product;


class TestController extends Controller {

    /**
     * @throws \yii\db\Exception
     */
    public function actionInsert() {
        $query = \Yii::$app->db->createCommand()->insert('user', [
            'username' => 'username_1',
            'name' => 'name_1',
            'password_hash' => 'as9d0fasdf0as9df8',
            'creator_id' => 121,
            'created_id' => 232]);
        $query->execute();

        $query = \Yii::$app->db->createCommand()->insert('user', [
            'username' => 'username_2',
            'name' => 'name_2',
            'password_hash' => 'lkwqjwelrjqwepoor',
            'creator_id' => 375,
            'created_id' => 287]);
        $query->execute();

        $query = \Yii::$app->db->createCommand()->insert('user', [
            'username' => 'username_3',
            'name' => 'name_3',
            'password_hash' => 'a9s0difsad0fia9sd',
            'creator_id' => 835,
            'created_id' => 735]);
        $query->execute();

        $query = \Yii::$app->db->createCommand()
            ->batchInsert('task', ['title', 'description', 'creator_id', 'created_id'], [
            ['task_1', 'description_1', 1, 232],
            ['task_2', 'description_2', 2, 287],
            ['task_3', 'description_3', 3, 735]
        ]);
        $query->execute();
    }

    /**
     * @array $result array
     */
    public function actionSelect() {
        $id = 1;
        $query1 = (new Query())->from('user')->where(['=', 'id', $id])->limit(1);
        $result1 = $query1->all();

        $query2 = (new Query())->from('user')->where(['>', 'id', $id])->orderBy(['name' => SORT_ASC]);
        $result2 = $query2->all();

        $query3 = (new Query())->from('user');
        $result3 = $query3->count();

        $query4 = (new Query())->from('task')->innerJoin('user', 'user.id = task.creator_id');
        $result4 = $query4->all();

        $result = [$result1, $result2, $result3, $result4];

        return $result;
    }


    /**
     * @return string
     */
    public function actionIndex() {
        $result = $this->actionSelect();
        return $this->render('index', [
            'result' => $result
        ]);
    }
}
