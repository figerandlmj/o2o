<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/27
 * Time: 9:07
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time', 'description', 'update_time'];

    public function items()
    {
        return $this->belongsTo('Image', 'topic_img_id');
    }

    public function childItems()
    {
        return $this->hasMany('Product', 'category_id','id');
    }

    public static function getAllCategory()
    {
        $allCategoryData = self::with('items')->select();
        return $allCategoryData;
    }

    public static function getChildIdToData($categoryId)
    {
        $childCategoryData = self::with('childItems')->where(array('id' => $categoryId))->select();

        return $childCategoryData;
    }

}
