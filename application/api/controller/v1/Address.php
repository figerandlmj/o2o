<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/6
 * Time: 9:15
 */

namespace app\api\controller\v1;

use app\api\model\User as UserModel;
use app\api\service\UserToken;
use app\api\validate\AddressValidate;
use app\lib\exception\SuccessMsgException;
use app\lib\exception\UserException;
use app\api\controller\BaseController;
use app\api\model\UserAddress;
use think\Controller;

class Address extends BaseController
{
    /**
     *在执行 createAndUpdateUserAddress 方法之前 要先执行 checkPrimayScope
     */
    protected $beforeActionList = [
        'checkPrimayScope' => ['only' => 'createAndUpdateUserAddress']
    ];

    /**
     * [createAndUpdateUserAddress 创建地址]
     */
    public function createAndUpdateUserAddress()
    {
        //  token 是要header中传递
        //  检查传过来的地址是否存在
        $validate = new AddressValidate();

        $validate->goCheck();

        //  得到token获取uid
        $uid = UserToken::getUidByToken();

        //  用uid 去获取用户地址 是否存在
        $user = UserModel::get($uid);

        $userAddress = $user->address;

        if (!$user) {
            throw new UserException();
        }

        $address = $validate->getDataByRule(input('post.'));
       
        if (!$userAddress) {
            //增加
            $user->address()->save($address);
        } else {
            //修改
            $user->address->save($address);
        }

        // 接收用户的地址 不能接收传过来的所有的 只要我们规则定义的
        throw new SuccessMsgException();
    }
}