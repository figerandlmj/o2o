<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/29
 * Time: 21:35
 */

namespace app\api\service;

use app\lib\exception\TokenMissException;
use app\lib\exception\WechatException;
use curl\Curl\Curl;
use Think\Cache;
use think\Exception;
use think\Loader;
use app\api\model\User as userModel;

class UserToken extends Token
{
    protected $code = "";
    protected $wxAppId = "";
    protected $wxAppScript = "";
    protected $wxLoginUrl = "";
    protected $curl = '';

    public function __construct($code)
    {
        Loader::import('curl.Curl');
        $this->curl = new Curl();
        $this->code = $code;

        $this->wxAppId = config('wx.app_id');
        $this->wxAppScript = config('wx.app_script');

        //微信登录url
        $this->wxLoginUrl = sprintf(config('wx.wx_login'), $this->wxAppId, $this->wxAppScript, $this->code);

    }

    public function getToken()
    {
        //1.curl请求微信数据 获取微信登录数据
        //2.判断返回回来的数据 失败返回信息
        //3.成功 获取openid 去数据库查找 看看当前的这个是否存在
        //4.不管是添加还是已经存在 都返回user_id
        //5.把数据写到缓存 (随机生成key value就是保存到缓存的数据 获取的时间) 成功了 返回token
        $this->curl->url($this->wxLoginUrl);
        $result = $this->curl->data();

        if (is_null(json_decode($result))) {
            throw new Exception('获取微信session_key错误,微信内部错误');
        } else {
            $result = json_decode($result, true);
            //判断返回的值中有没有errcode
            $loginId = array_key_exists('errcode', $result);
            if ($loginId) {
                //返回错误信息
                $this->errorProcess($result);
            } else {
                //不管是添加还是已经存在 都返回user_id
                return $this->grantProcess($result);
            }
        }
    }

    public function grantProcess($result)
    {
        //拿到openid 去数据获取
        $openid = $result['openid'];
        //数据库中查看这个openid是否存在
        $user = userModel::getOpenidToinfo($openid);
        //如果存在不处理 不存在 新增一条user记录
        if (empty($user)) {
            $uid = $this->newUser($openid);
        } else {
            $uid = $user['id'];
        }

        //准备要保存到缓存的数据
        //
        $cacheData = $this->prepareCacheData($result, $uid);

        //生成令牌 准备缓存数据 写入缓存
        $token = $this->saveCacheData($cacheData);
        //把令牌返回
        return $token;
    }

    protected function saveCacheData($cacheData)
    {
        //生成key
        $key = self::prepareKey();
        $value = json_encode($cacheData);

        //过期时间
        $ext_time = config('setting.exp_in_time');

        //保存到缓存
        $request = cache($key, $value, $ext_time);

        if (!$request) {
            throw new TokenMissException([
                'msg' => '服务器错误',
                'errorCode' => '10001'
            ]);
        }

        return $key;
    }

    //准备数据 并写入缓存 scope设置16 权限最大
    protected function prepareCacheData($result, $uid)
    {
        $data['data'] = $result;
        $data['uid'] = $uid;
        $data['scope'] = 16;
        return $data;
    }

    protected function newUser($openid)
    {
        $data = userModel::create([
            'openid' => $openid,
            'create_time' => time(),
        ]);

        return $data->id;
    }

    public function errorProcess($result)
    {
        throw new WechatException([
            'errorCode' => $result['errcode'],
            'msg' => $result['errmsg'],
        ]);
    }

    public static function getUidByToken()
    {
        return Token::getUidByToken();
    }


}