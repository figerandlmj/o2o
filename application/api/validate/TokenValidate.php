<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/29
 * Time: 21:33
 */

namespace app\api\validate;


class TokenValidate extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty',
    ];

    protected $message = [
        'code' => 'code 必须传递,不能为空',
    ];


}