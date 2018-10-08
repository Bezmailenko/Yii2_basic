<?php

namespace app\components;
use Yii\base\Component;

class TestService extends Component
{
    public $prop = 'default';

    public function run()
    {
    return $this->prop;
    }
}