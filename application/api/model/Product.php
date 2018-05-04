<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/9/4
 * Time: 9:52
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = ['delete_time', 'category_id', 'stock', 'from', 'create_time', 'update_time', 'summary', 'img_id', 'pivot'];


    public function getMainImgUrlAttr($value, $data)
    {
        return $this->getFixImagPath($value, $data);
    }

    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function propertys()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    /**
     * [getRcenntGoods 获取最近的商品]
     * @param $count 获取的条数
     * @return $data 返回数据
     */
    public static function getRcenntGoods($count)
    {
        return self::limit($count)->order('create_time desc')->select();
    }

    public static function getIdToDatails($productId = '')
    {

        $data = self::with([
            'imgs' => function ($query) {
                $query->with(['imageUrl'])->order('order', 'asc');
            }
        ])
            ->with(['propertys'])
            ->where('id', '=', $productId)
            ->find();

        return $data;
    }

}