<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/20
 * Time: 15:38
 */

namespace app\lib\exception;

use think\exception\Handle;
use think\Log;
use think\Request;
use think\Exception;


class ExceptionHandler extends Handle
{
    private $code = "";
    private $msg = "";
    private $errorCode = "";

    public function render(\Exception $e)
    {
        //这个处理2种异常
        if ($e instanceof BaseException) {
            //自定义错误
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            //服务器错误
            if (config('app_debug')) {
                return parent::render($e);
            } else {
                $this->code = "500";
                $this->msg = "服务器内部错误";
                $this->errorCode = "999";
                //一般的服务器错误都要写进日志
                $this->recordErrorLog($e);
            }
        }

        $request = Request::instance();

        $result = [
            'error_code' => $this->errorCode,
            'msg' => $this->msg,
            'request_url' => $request->url()
        ];

        return json($result, $this->code);
    }

    private function recordErrorLog(\Exception $e)
    {

        log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error'],
        ]);

        Log::record('测试日志信息，这是警告级别', 'error');
    }
}