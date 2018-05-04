<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/27
 * Time: 9:48
 */

namespace app\lib\exception;


class CategoryNullException extends BaseException
{
    //http 的状态 200 ,400 ....
    public $code = "400";
    //错误信息
    public $msg = "请求的Category不存在";
    //自定义状态
    public $errorCode = "30000";

}