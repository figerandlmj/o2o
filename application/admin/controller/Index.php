<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/21
 * Time: 10:49
 */

namespace app\admin\controller;

use app\lib\exception\ParameterException;
use think\Controller;

class Index extends Controller
{
    /**
     * [index 首页]
     */
    public function index()
    {
        $serverInfo = getServerInfo();
        if (!$serverInfo) {

            $e = new ParameterException([
                'msg' => '服务器数据为空',
                'code' => '400'
            ]);

            throw $e;
        }

        $this->assign('serverInfo', $serverInfo);

        return view('index', ['title' => '首页']);
    }

}