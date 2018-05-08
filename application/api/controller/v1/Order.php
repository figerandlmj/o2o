<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/3/22
 * Time: 13:45
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\service\Token;
use app\api\service\Order as OrderServer;
use think\Controller;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
    ];
    
    /**
     * [placeOrder 下单]
     */
    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        //接收传过来的订单商品信息
        $oProducts = input('post.products/a');
        
        //当前下订单的人
        $uid = Token::getUidByToken();

        $order = new OrderServer();
        $status = $order->place($oProducts, $uid);
        
        return $status;
    }
}
