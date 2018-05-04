<?php
namespace app\api\validate;

use think\Request;
use think\Validate;

class TestValidate extends BaseValidate
{
	protected $rule = [
        'name'  =>  'require|max:25',
        'email' =>  'email',
    ];

    protected $message  =   [
        'name.require' => '名称必须',
        'name.max'     => '名称最多不能超过25个字符',
        'email'        => '邮箱格式错误',    
    ];
    

}
