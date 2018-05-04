<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/20
 * Time: 9:39
 */

namespace app\api\validate;


class AddressValidate extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'mobile' => 'require|isNotEmpty|isMobileNumber',
        'province' => 'require|isNotEmpty',
        'city' => 'require|isNotEmpty',
        'country' => 'require|isNotEmpty',
        'detail' => 'require|isNotEmpty',
    ];
}