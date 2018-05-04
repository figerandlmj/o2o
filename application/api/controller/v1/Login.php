<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/9
 * Time: 10:15
 */

namespace app\api\controller\v1;

use app\api\validate\UserValidate;
use think\Controller;
use think\Request;

class Login extends Controller
{
    /**
     * 后台登录首页
     */
    public function index()
    {
        return view('index', ['title_name' => '后台首页']);
    }

    public function dologin()
    {
        $request = Request::instance();
        if ($request->isAjax()) {

            $data = $request->param();

            $result = $this->validate($data, 'UserValidate.login');
            if ($result != true) {
                return ['status' => 0, 'data' => $result];
            }

            $adminModel = Loader::model("Admin");
            $userRow = $adminModel->login($data);

            if ($userRow === false) {
                return $this->error($adminModel->getError());
            }

            return $this->success('登录成功', Url::build('/admin/index/index'));
        } else {
            return view('index', ['title_name' => '登录']); 
        }
    }

}