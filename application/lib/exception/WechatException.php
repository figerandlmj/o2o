<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/31
 * Time: 13:12
 */

namespace app\lib\exception;


class WechatException extends BaseException
{
    //http 的状态 200 ,400 ....
    public $code = "500";
    //错误信息
    public $msg = "微信返回信息";
    //自定义状态
    public $errorCode = "20000";

}