<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/3/19
 * Time: 9:31
 */
namespace app\api\controller;

use app\api\service\Token;
use think\Controller;

class BaseController extends Controller
{
    protected function checkPrimayScope()
    {
        return Token::needPrimayScope();
    }

    protected function checkExclusiveScope()
    {
        return Token::needExclusiveScope();
    }
}