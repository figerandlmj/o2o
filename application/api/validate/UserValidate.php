<?php

namespace app\api\validate;

class UserValidate extends BaseValidate
{
    protected $rule = [
        'mobile' => 'require|length:11|isNotEmpty',
        'password' => 'isNotEmpty|length:6,20',
    ];

    protected $message = [
        'mobile.require' => '账号必须',
        'mobile.length' => '请输入正确用户名！',
        'password.length' => '密码应在6-20之间',
    ];

    protected $scene = [
        'login' => ['mobile', 'password'],
    ];

}


