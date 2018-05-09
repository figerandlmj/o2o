<?php

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/5/7
 * Time: 9:44
 */

namespace app\api\service;

use app\api\model\Product;
use app\lib\exception\OrderException;

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

    /**
     * getOrderStatus function
     *
     * @return array 订单的状态
     */
    protected function getOrderStatus()
    {
        //因为买的这个商品不是一个
        $status = [
            'pass' => 'true',// 
            'orderPrice' => 0,//订单的总价
            'pStatusArray' => [] //单个商品的信息
        ];

        foreach ($this->oProducts as $oProducts) {
            $pStatus = $this->getProductStatus(
                $oProducts['product_id'],
                $oProducts['count'],
                $this->products
            );

            //有的是true  没有的是 false
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }

            $status['orderPrice'] += $pStatus['count'];

            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    /**
     * getProductStatus 获取当前这个商品的信息
     *
     * @param [string] $oId  订单中商品的id
     * @param [string] $oCount 订单中商品的数量
     * @param [array] $products 订单中的商品id对应数据库中的信息
     * @return array  当前这个商品的信息
     */
    protected function getProductStatus($oPid, $oCount, $products)
    {
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => null,
            'totalPrice' => 0
        ];

        for ($i = 0; $i < count($products); $i++) {
            if ($oPid == $products[$i]['id']) {
                $pIndex = $i;
            }
        }

        if ($pIndex == -1) {
            throw new OrderException([
                'msg' => '商品id为' . $oPid . '商品不存在'
            ]);
        } else {
            $pStatus['id'] = $products[$pIndex]['id'];
            $pStatus['count'] = $oCount;
            $pStatus['name'] = $products[$pIndex]['name'];
            $pStatus['totalPrice'] = $products[$pIndex]['price'] * $oCount;

            if ($products[$pIndex]['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }

        return $pStatus;
    }

    /**
     * getProductsByOrders 获取订单中商品id对应的详情
     *
     * @param [array] $oProducts 订单详情
     * @return array
     */
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
