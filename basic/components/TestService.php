<?php

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