<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/5/7
 * Time: 9:44
 */

namespace app\api\service;

use app\api\model\Product;

class Order
{
    protected $uid;
    //订单中的商品
    protected $oProducts;
    //数据库中原始的商品
    protected $products;

    public function place($oProducts, $uid)
    {
        $this->uid = $uid;
        $this->oProducts = $oProducts;
        //获取订单中商品的原始信息
        $this->products = $this->getProductsByOrders($oProducts);

        //比较订单中的库存
        $status = $this->getOrderStatus();
        return json($status);
    }

    protected function getOrderStatus()
    {
        //因为买的这个商品不是一个
        $status = [
            'pass'=>'true',
            'orderPrice'=>0,
            'pStatusArray'=>[]
        ];

        
    }

    protected function getProductsByOrders($oProducts)
    {
        $oPid = [];

        foreach ($oProducts as $product) {
            array_push($oPid, $product['product_id']);
        }

        $product = Product::all($oPid)
            ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();

        return $product;
    }
}
