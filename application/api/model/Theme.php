<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/9/4
 * Time: 9:53
 */

namespace app\api\model;

class Theme extends BaseModel
{
    protected $hidden = ['delete_time', 'topic_img_id', 'head_img_id'];

    public function topImage()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImage()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }


    public static function getSimpleIdsToInfos($ids = "")
    {
        return self::with('topImage,headImage')->select($ids);
    }
    
    /**
     * [productImg 多对多的关系的建立]
     */
    public function productImg()
    {
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }
    
    public static function getThmemProducts($id = "")
    {
        return self::with('productImg,topImage,headImage')->select($id);
    }

}