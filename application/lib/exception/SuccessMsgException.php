<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/28
 * Time: 10:43
 */

namespace app\lib\exception;


class SuccessMsgException extends BaseException
{
    //http 的状态 200 ,400 ....
    public $code = "200";
    //错误信息
    public $msg = "修改或新增用户数据成功！";
    //自定义状态
    public $errorCode = "200000";
}