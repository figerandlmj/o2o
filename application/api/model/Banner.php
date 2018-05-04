<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/16
 * Time: 22:17
 */

namespace app\api\model;

class Banner extends BaseModel
{
    protected $hidden = ['description', 'width', 'heigth', 'type', 'code', 'delete_time', 'update_time'];

    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    /**
     * [getBannerById ]
     * @param string $brandId
     */
    public static function getBannerById($brandId = "")
    {
        //Banner 模型 连了 items模型  items模型有连了image模型
        $banerData = self::with(['items', 'items.image'])->find($brandId);
        return $banerData;
    }


}





