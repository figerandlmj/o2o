<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/29
 * Time: 21:33
 */

namespace app\api\model;


class User extends BaseModel
{
    public static function getOpenidToinfo($openid)
    {
        $data = self::where('openid', '=', $openid)->find();
        return $data;
    }

    // 获取
    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

}