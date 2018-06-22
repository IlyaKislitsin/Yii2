<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 11.06.2018
 * Time: 22:02
 */

namespace app\components;


use yii\base\Component;

class TestService extends Component
{
    protected $test = "Метод работает!!!";

    /**
     * @return string
     */
    public function getTest()
    {
        return $this->test;
    }

    public function setTest($var) {
        $this->test = $var;
    }
}

