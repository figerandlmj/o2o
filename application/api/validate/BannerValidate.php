<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/23
 * Time: 14:57
 */

namespace app\api\validate;


class BannerValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
        'name' => 'require|max:50',
        'code' => 'require|max:20',
        'width' => 'require|number|max:5',
        'heigth' => 'require|number|max:5',
    ];

    protected $message = [
        'name.require' => '-位置名称必须',
        'name.between' => '-位置名称不要超过50个字符',
        'code.require' => '-位置代码必须',
        'code.between' => '-位置代码不要超过20个字符',
        'width.require' => '-建议宽度必须',
        'width.number' => '-建议宽度必须是数字',
        'width.between' => '-建议宽度不要超过5位数',
        'heigth.require' => '-建议宽度必须',
        'heigth.number' => '-建议宽度必须是数字',
        'heigth.between' => '-建议宽度不要超过5位数',
    ];

    protected $scene = [
        'insert' => ['name', 'code', 'width', 'heigth'],
        'edit' => ['id', 'name', 'code', 'width', 'heigth'],
    ];

    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }
}