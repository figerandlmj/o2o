<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/24
 * Time: 14:00
 */

namespace app\api\validate;

use think\Validate;

class MobileValidate extends BaseValidate
{
    protected $rule = [
        'mobile' => 'require|max:11|isMobileNumber',
    ];
}