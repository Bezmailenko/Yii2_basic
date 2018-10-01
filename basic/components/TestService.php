<?php
/**
 * Created by PhpStorm.
 * User: Склад
 * Date: 01.10.2018
 * Time: 14:51
 */
namespace app\components;
use Yii\base\component;

class TestService extends component
{
    public $prop = 'default';

    public function run()
    {
    return $this->prop;
    }
}