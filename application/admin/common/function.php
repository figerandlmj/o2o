<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/22
 * Time: 16:17
 */

use think\Request;

function getServerInfo()
{
    //获取服务器信息
    $info = array(
        '操作系统' => PHP_OS,
        '运行环境' => $_SERVER["SERVER_SOFTWARE"],
        '主机名' => $_SERVER['SERVER_NAME'],
        'WEB服务端口' => $_SERVER['SERVER_PORT'],
        '网站文档目录' => $_SERVER["DOCUMENT_ROOT"],
        '浏览器信息' => substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
        '通信协议' => $_SERVER['SERVER_PROTOCOL'],
        '请求方法' => $_SERVER['REQUEST_METHOD'],
        'ThinkPHP版本' => THINK_VERSION,
        '上传附件限制' => ini_get('upload_max_filesize'),
        '执行时间限制' => ini_get('max_execution_time') . '秒',
        '服务器时间' => date("Y年n月j日 H:i:s"),
        '北京时间' => gmdate("Y年n月j日 H:i:s", time() + 8 * 3600),
        '服务器域名/IP' => $_SERVER['SERVER_NAME'] . ' [ ' . gethostbyname($_SERVER['SERVER_NAME']) . ' ]',
        '用户的IP地址' => $_SERVER['REMOTE_ADDR'],
        '剩余空间' => round((disk_free_space(".") / (1024 * 1024)), 2) . 'M',
    );

    return $info;
}

function selfAjax()
{
    $request = Request::instance();
    if (!$request->isAjax()) {

        $e = new ParameterException([
            'msg' => '非法请求',
            'code' => '400'
        ]);
        throw $e;
    }
}

/**
 * [isAddOrEdit 判断是添加还是删除 就是判断data中的id是否存在 存在在判断是否为空 空添加 ]
 * @param array $data 提交数据
 */
function isAddOrEdit($data = array())
{
    if (isset($data['id']) && !empty($data['id'])) return false; else return true;
}

function isStringExists($string = "", $str = ",")
{
    if (strrpos($string, $str) === 'true') {
        return true;
    } else {
        return false;
    }
}





















