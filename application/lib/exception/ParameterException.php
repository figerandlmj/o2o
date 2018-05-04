<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/20
 * Time: 19:20
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    //http 的状态 200 ,400 ....
    public $code = "400";
    //错误信息
    public $msg = "参数错误";
    //自定义状态
    public $errorCode = "10000";
}