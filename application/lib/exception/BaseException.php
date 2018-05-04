<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/20
 * Time: 15:52
 */

namespace app\lib\exception;

use Exception;
use Throwable;

class BaseException extends Exception
{
    //http 的状态 200 ,400 ....
    public $code = "400";
    //错误信息
    public $msg = "invalidate params";
    //自定义状态
    public $errorCode = "10000";

    public function __construct($params = [])
    {
        if (!is_array($params)) {
            return;
        }

        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }

        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }

        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }

}