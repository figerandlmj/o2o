<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/27
 * Time: 21:11
 */

namespace app\api\model;


use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['id', 'from', 'delete_time', 'update_time'];

    public function getUrlAttr($value, $data)
    {
        return $this->getFixImagPath($value, $data);
    }
}