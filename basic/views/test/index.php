<?php
/**
 * @var String $var
 *
 * @var $result \app\models\Product
 * @var string $test
*/
echo 'RESULT-1: '.\yii\helpers\VarDumper::dumpAsString($result[0], 5, true).'</br>';
echo 'RESULT-2: '.\yii\helpers\VarDumper::dumpAsString($result[1], 5, true).'</br>';
echo 'RESULT-3: '.\yii\helpers\VarDumper::dumpAsString($result[2], 5, true).'</br>';
echo 'RESULT-4: '.\yii\helpers\VarDumper::dumpAsString($result[3], 5, true);
?>
<!--<p>--><?//= \yii\widgets\DetailView::widget(['model' => $model]) ?><!--</p>-->