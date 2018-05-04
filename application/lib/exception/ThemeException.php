<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/9/9
 * Time: 23:26
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    //http 的状态 200 ,400 ....
    public $code = "404";
    //错误信息
    public $msg = "请求的Theme不存在";
    //自定义状态
    public $errorCode = "30000";

}