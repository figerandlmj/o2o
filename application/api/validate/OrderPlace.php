<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/5/4
 * Time: 9:23
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;


class OrderPlace extends BaseValidate
{
    protected $rule = [
        '$products' => 'checkProducts'
    ];

    protected $singleRule = [
        'product_id' => 'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger'
    ];

    protected function checkProducts($value)
    {
        //先判断外面的是不是 一个数组
        if (!is_array($value)) {
            throw new ParameterException([
                'msg' => '商品列表不存在'
            ]);
        }

        if (empty($value)) {
            throw new ParameterException([
                'msg' => '商品列表不存在'
            ]);
        }

        foreach ($value as $val) {
            $this->checkProduct($val);
        }

        return true;
    }

    protected function checkProduct($value)
    {
        $validate = new BaseValidate($this->singleRule);

        $result = $validate->check($value);

        if (!$result) {
            throw new ParameterException([
                'msg' => '商品列表参数错误',
            ]);
        }


    }

}