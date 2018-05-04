<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/20
 * Time: 16:13
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    //http 的状态 200 ,400 ....
    public $code = "400";
    //错误信息
    public $msg = "请求的banner不存在";
    //自定义状态
    public $errorCode = "40000";
}