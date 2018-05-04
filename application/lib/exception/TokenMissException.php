<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/2
 * Time: 11:21
 */

namespace app\lib\exception;


class TokenMissException extends BaseException
{
    //http 的状态 200 ,400 ....
    public $code = "400";
    //错误信息
    public $msg = "token不存在或者token已过期";
    //自定义状态
    public $errorCode = "100001";
}