<?php
namespace app\lib\exception;

class OrderException extends BaseException
{
     //http 的状态 200 ,400 ....
    public $code = "400";
    //错误信息
    public $msg = "商品id不存在";
    //自定义状态
    public $errorCode = "80000";
}
