<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>6
// +----------------------------------------------------------------------
use think\Route;

//前台 多版本控制
Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');
//http://local.o2o.com/api/v1/Theme?id=1,2,3
Route::get('api/:version/Theme', 'api/:version.Theme/getSimpleTheme');

//http://local.o2o.com/api/v1/Theme/1
Route::get('api/:version/Theme/:id', 'api/:version.Theme/getComplexOne');

Route::get('api/:version/updateFirtyCard/', 'api/:version.Theme/updateFirtyCard');
Route::get('api/:version/updateEnghtStatus/', 'api/:version.Theme/updateEnghtStatus');
Route::get('getInsert', 'api/v1.Banner/getInsert');

//获取最近的商品 可以传count不传就是默认值 也可以传
//http://local.o2o.com/api/v1/Product/recent?count=22
Route::get('api/:version/product/recent', 'api/:version.Product/getRecentGoods');
//获取所有分类
Route::get('api/:version/category/all', 'api/:version.Category/getAllCategory');
//获取一个分类下面的子分类 下面的路由
//在调用的方法中 调用的参数都是一样的
//http://local.o2o.com/api/v1/category/child?categoryId=1
Route::get('api/:version/category/childData', 'api/:version.Category/getIdToChildren');


//四川总工会路径
//http://local.o2o.com/api/v1/Product/sms?mobile=13382322040
Route::get('api/:version/product/sms', 'api/:version.Product/sendSmsCode');
Route::get('api/:version/product/insertSql', 'api/:version.Product/getJsonDataToInsert');

//http://local.o2o.com/api/v1/product/detail?id=11  在方法中接收用$id
Route::get('api/:version/product/detail', 'api/:version.Product/getIdTodetails');

Route::get('api/:version/address', 'api/:version.Address/createAndUpdateUserAddress');

//登录
Route::get('api/:version/login/index', 'api/:version.Login/index');
Route::post('api/:version/login/dologin', 'api/:version.Login/dologin');

//注册
Route::get('api/:version/product/register', 'api/:version.Product/doRegister');

//获取用户数据
Route::get('api/:version/product/user', 'api/:version.Product/getUserInfo');

Route::get('api/:version/product/info', 'api/:version.Product/getInfo');

Route::get('api/:version/test/test', 'api/:version.Test/test');
//后台
Route::get('admin/index', 'api/admin/Index/index');
Route::get('admin/inportExcel', 'api/admin/Excel/inportExcel');

//获取token
Route::post('api/:version/token/user', 'api/:version.Token/getToken');

//Address
Route::post('api/:version/address', 'api/:version.Address/createAndUpdateUserAddress');

//Order 下单
Route::post('api/:version/order', 'api/:version.Order/placeOrder');
