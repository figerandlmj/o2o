<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/9/9
 * Time: 22:26
 */

namespace app\api\validate;


class IDCollectionStrs extends BaseValidate
{
    protected $rule = [
        'id' => 'require|checkIds',
    ];

    protected $message = [
        'id' => 'id必须是带都,的字符串,比如1,2,3...',
    ];

    protected function checkIds($value)
    {
        $value = explode(',', $value);
        if (empty($value)) {
            return false;
        }

        foreach ($value as $val) {
            if (!$this->isPositiveInteger($val)) {
                return false;
            }
        }
        return true;
    }

}