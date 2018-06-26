<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 19.06.2018
 * Time: 11:25
 */


function _log($data){
    \Yii::info(\yii\helpers\VarDumper::dumpAsString($data, 5), '_');
}
function _end($data){
    echo \yii\helpers\VarDumper::dumpAsString($data, 5, true);
    exit();
}