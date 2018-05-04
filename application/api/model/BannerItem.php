<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/27
 * Time: 20:40
 */

namespace app\api\model;


use think\Model;

class BannerItem extends BaseModel
{
    protected $hidden = ['id', 'key_word', 'type', 'delete_time', 'banner_id', 'update_time'];

    public function image()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}