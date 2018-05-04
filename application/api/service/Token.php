<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/2
 * Time: 10:32
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbbinException;
use app\lib\exception\TokenMissException;
use think\Request;
use think\Cache;

class Token
{
    protected static function prepareKey()
    {
        $key = createRandomStr(32);
        $time = time();
        $salt = config('secrpt.salt');
        return md5($key . $time . $salt);
    }

    public static function getCurrentTokenVar($vars)
    {
        $token = Request::instance()->header('token');

        if (!$token) {
            throw new TokenMissException();
        } else {

            if (!is_array($token)) {
                $data = json_decode(Cache::get($token), true);
                
                if (array_key_exists($vars, $data)) {
                    return $data[$vars];
                } else {
                    throw new TokenMissException('请求的' . $vars . '数据不存在！');
                }
            } else {
                echo "string";die;
                if (array_key_exists($vars, $token)) {
                    return $token[$vars];
                } else {
                    throw new TokenMissException('请求的' . $vars . '数据不存在！');
                }
            }
        }
    }

    protected static function getUidByToken()
    {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    /**
     * [needPrimayScope ]
     * @return bool []
     */
    public static function needPrimayScope()
    {
        $scope = self::getCurrentTokenVar('scope');

        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            } else {
                throw new ForbbinException();
            }
        } else {
            throw new ForbbinException();
        }
    }

    /**
     * [needExclusiveScope 只能是用户才能访问]
     */
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');

        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbbinException();
            }
        } else {
            throw new ForbbinException();
        }
    }

}