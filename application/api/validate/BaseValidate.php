<?php

namespace app\api\validate;

use app\lib\exception\ParameterException;
use app\lib\exception\UserException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{

    public function goCheck($msg = "")
    {
        $params = Request::instance()->param();
        
        //batch 开启多个验证 并验证场景
        $result = $this->batch()->scene($msg)->check($params);
        
        if (!$result) {
            $e = new ParameterException([
                'msg' => $this->error,
                'code' => '200'
            ]);

            throw $e;
        } else {
            return true;
        }
    }

    /**
     * [isPositiveInteger 检查是否是正整数]
     * @param $value 值
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool []
     */
    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return false;
    }

    /**
     * [isMobileNumber ]
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool []
     */
    protected function isMobileNumber($value, $rule = '', $data = '', $field = '')
    {
        if (!is_numeric($value)) {
            return false;
        }

        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $value) ? true : false;
    }

    /**
     * [isNotEmpty 判断是否为空]
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool []
     */
    protected function isNotEmpty($value, $rule = '', $data = '', $field = '')
    {
        if (empty($value)) {
            return false;
        }
        return true;
    }

    public function getDataByRule($arrs)
    {
        /**
         * 如果传递的参数中有 uid user_id 就是恶意请求
         */
        if (array_key_exists('uid', $arrs) || array_key_exists('user_id', $arrs)) {
            throw new UserException([
                'code' => '20000',
                'msg' => '恶意请求',
            ]);
        }

        $newArr = array();
        
        foreach ($this->rule as $key => $val) {
            $newArr[$key] = $arrs[$key];
        }

        return $newArr;
    }
}