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
use think\Controller;

class Order extends BaseController
{

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
    ];

    /**
     * [placeOrder 下单]
     */
    public function placeOrder()
    {
       (new OrderPlace())->goCheck();
        
    }
}