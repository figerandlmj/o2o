<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/24
 * Time: 13:29
 */

namespace app\lib\exception;


class ProductMissException extends BaseException
{
    //http 的状态 200 ,400 ....
    public $code = "400";
    //错误信息
    public $msg = "请求的Product数据不存在";
    //自定义状态
    public $errorCode = "20000";
}