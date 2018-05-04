<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/23
 * Time: 18:19
 */

namespace app\lib\exception;

class UserException extends BaseException
{
    //http 的状态 200 ,400 ....
    public $code = "400";
    //错误信息
    public $msg = "用户地址不存在";
    //自定义状态
    public $errorCode = "500001";
}