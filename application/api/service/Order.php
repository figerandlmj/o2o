<?php
namespace app\api\service;

use app\api\model\Product;
use app\lib\exception\OrderException;
use app\api\model\UserAddress;
use app\api\model\User;
use app\lib\exception\UserException;
use app\api\model\Order as orderModel;
use app\api\model\OrderProduct;
use think\image\Exception;

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
        //检查库存是否通过
        if (!$status['pass']) {
            $status['order_id'] = '-1';
            return json($status);
        }
        //订单快照
        $snapOrder = $this->snapOrder($status);

        //创建订单
        $status = $this->createOrder($snapOrder);
        $status['pass'] = true;
        return $status;
    }

    protected function createOrder($snapOrder)
    {
        try {
            $orderModel = new orderModel();
            $orderNo = $this->makeOrderNo();
            $orderModel->order_no = $orderNo;
            $orderModel->user_id = $this->uid;
            $orderModel->total_price = $snapOrder['orderPrice'];
            $orderModel->total_count = $snapOrder['totalCount'];
            $orderModel->snap_img = $snap['snapImg'];
            $orderModel->snap_name = $snap['snapName'];
            $orderModel->snap_address = $snap['snapAddress'];
            $orderModel->snap_items = json_encode($snap['pStatus']);

            $orderModel->save();

            $order_id = $orderModel->id;
            $create_time = $orderModel->create_time;

            foreach ($this->oProducts as $key => &$val) {
                $val['order_id'] = $order_id;
            }

            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            return [
                'order_no' => $orderNo,
                'order_id' => $order_id,
                'create_time' => $create_time
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
            'd'
        ) . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
            '%02d',
            rand(0, 99)
        );
        return $orderSn;
    }

    protected function snapOrder($status)
    {
        $snapStatus = [
            'orderPrice' => $status['orderPrice'],
            'totalCount' => $status['totalCount'],
            'pStatus' => $status['pStatusArray'],
            'snapName' => $this->products['0']['name'],
            'snapImg' => $this->products['0']['main_img_url'],
            'snapAddress' => json_encode($this->getUserAddress())
        ];

        if (count($this->products) > 1) {
            $snapStatus['snapName'] .= '等';
        }

        return $snapStatus;
    }

    /**
     * getUserAddress function 获取用户地址
     *
     * @return array
     */
    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)->find();
        if (!$userAddress) {
            throw new UserException([
                'errorCode' => '600001',
                'msg' => '收货地址不存在！'
            ]);
        }
        return $userAddress->toArray();
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
            'totalCount' => 0,
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

            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            //把单个商品的信息写到数组中
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
        //有的商品在数据库中不存在的
        $pIndex = -1;
        $pStatus = [
            'id' => null,//商品id
            'haveStock' => false,//是否有库存
            'count' => 0,//总数
            'name' => null,//商品名
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
