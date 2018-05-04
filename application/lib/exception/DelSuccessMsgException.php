<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/2/23
 * Time: 15:32
 */

namespace app\lib\exception;


class DelSuccessMsgException extends BaseException
{
    //http 的状态 200 ,400 ....
    public $code = "200";
    //错误信息
    public $msg = "删除成功！";
    //自定义状态
    public $errorCode = "200000";

}