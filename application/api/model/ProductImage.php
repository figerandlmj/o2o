<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/3
 * Time: 11:11
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['id', 'delete_time','product_id'];

    public function imageUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}