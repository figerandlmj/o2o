<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/1/15
 * Time: 14:09
 */

namespace app\lib\exception;


class ForbbinException extends BaseException
{
    //http 的状态 200 ,400 ....
    public $code = "400";
    //错误信息
    public $msg = "scope已过期";
    //自定义状态
    public $errorCode = "40000";
}