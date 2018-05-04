<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/29
 * Time: 21:01
 */

namespace app\api\validate;


class CategoryValidate extends BaseValidate
{
    protected $rule = [
        'categoryId' => 'require|isPositiveInteger|isNotEmpty',
    ];

    protected $message = [
        'categoryId' => '分类id 必须传递,不能为空,并且是正整数',
    ];

}