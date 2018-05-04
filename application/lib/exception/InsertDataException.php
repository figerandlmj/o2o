<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/23
 * Time: 15:56
 */

namespace app\lib\exception;


class InsertDataException extends BaseException
{
    //http 的状态 200 ,400 ....
    public $code = "200";
    //错误信息
    public $msg = "数据插入错误";
    //自定义状态
    public $errorCode = "10006";
}