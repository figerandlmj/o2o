<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/23
 * Time: 15:53
 */

namespace app\admin\model;

use think\Db;
use think\Model;

class Banner extends Model
{
    public function bannerImg()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    /**
     * [insertOrUpdateData ]
     * @param array $data
     * @return int|string []
     */
    public function insertOrUpdateData($data = array())
    {
        $data['update_time'] = time();

        if (array_key_exists('id', $data) && !empty($data['id'])) {
            //update
            $where['id'] = $data['id'];
            unset($data['id']);
            $id = Db::name('banner')->where($where)->update($data);
        } else {
            //insert
            $id = Db::name('banner')->insert($data);
        }
        if (!$id) {
            throw new BannerMissException([
                'msg' => '数据插入错误!',
                'errorCode' => 10006,
                'code' => 200
            ]);
        }
        return $id;
    }

    /**
     * [getAllBannerData 获取所有的]
     */
    public function getAllBannerData()
    {
        $list = self::with('bannerImg')->paginate(5);
        return $list;
    }

    /**
     * [getAddsIdToInfo 得到广告位置id去获取这条的广告数据]
     * @param string $addsId 广告位置id
     * @return array [当前广告id对应的数据]
     */
    public static function getAddsIdToInfo($addsId = "")
    {
        $banerData = Db::table("banner")->where('id', '=', $addsId)->select();
        return $banerData;
    }

    public  function delAdsBanner($addsId = "")
    {
        $banerData = Db::table("banner")->where('id', '=', $addsId)->delete();
        return $banerData;
    }

}