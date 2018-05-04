<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/29
 * Time: 21:28
 */

namespace app\api\controller\v1;

use app\api\service\UserToken;
use app\api\validate\TokenValidate;
use app\lib\exception\TokenMissException;
use think\Controller;

class Token extends Controller
{
    public function getToken($code)
    {
        //检查code 是否合法
        (new TokenValidate())->goCheck();

        //实例化类
        $ut = new UserToken($code);

        //获取token
        $data['token'] = $ut->getToken();

        if (empty($data['token'])) {
            throw new TokenMissException();
        }
        //返回token
        return json($data);
    }
}