<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/23
 * Time: 10:00
 */

namespace app\admin\controller;

use app\admin\model\Banner as addsModel;
use app\api\validate\BannerValidate;
use app\lib\exception\DelSuccessMsgException;
use app\lib\exception\InsertDataException;
use app\lib\exception\ParameterException;
use think\Controller;
use think\Request;

class Adds extends Controller
{
    public $request = '';
    public $data = ['code' => '200', 'msg' => '添加成功'];

    public $addsModel = "";

    public function __construct()
    {
        parent::__construct();
        $this->request = Request::instance();
        $this->addsModel = new addsModel();
    }

    /**
     * [location 广告位置表]
     */
    public function location()
    {
        //获取所有数据
        $bannerData = $this->addsModel->getAllBannerData();

        if (!empty($bannerData)) {
            $page = $bannerData->render();
            $this->assign('page', $page);
            $this->assign('count', count($bannerData));
        }

        $this->assign('bannerData', $bannerData);

        return view('location', ['title' => '广告管理', 'subTitle' => '广告位置']);
    }

    /**
     * [addLocation 添加广告位置]
     */
    public function addLocation()
    {
        if (empty($this->request->param())) {
            return view('addLocation', ['title' => '广告管理', 'subTitle' => '添加广告位置']);
        } else {
            $params = $this->request->param();
            if (isset($params['id'])) {
                $returnData = $this->addsModel->getAddsIdToInfo($params['id']);

                if (!$returnData) {
                    throw new InsertDataException([
                        'code' => '200',
                        'msg' => 'id不存在'
                    ]);
                }

                return view('addLocation', [
                    'title' => '广告管理',
                    'subTitle' => '编辑广告位置',
                    'returnData' => $returnData['0'],
                ]);
            }
            throw new InsertDataException([
                'code' => '200',
                'msg' => '非法操作'
            ]);
        }
    }

    /**
     * [doAddLocation 处理数据]
     */
    public function doAddLocation()
    {
        selfAjax();

        if (isAddOrEdit($this->request->param())) {
            (new BannerValidate())->scene('insert')->goCheck('insert');
        } else {
            (new BannerValidate())->scene('edit')->goCheck('edit');
        }

        $flag = $this->addsModel->insertOrUpdateData($this->request->param());

        if (!$flag) throw new InsertDataException();

        return json($this->data);
    }

    public function delLocation()
    {
        selfAjax();

        $requestData = $this->request->param();

        if (isset($requestData['id']) && empty($requestData['id']))
            throw new ParameterException(['code' => '200', 'msg' => '参数错误,请正确传递id']);

        //判断是不是批量删除的，根据字符串中是否存在,

        if (isStringExists($requestData['id'])) {
            //表示批量删除
            $ids = explode(',', $requestData['id']);
            foreach ($ids as $key => $val) {
                $this->addsModel->delAdsBanner($val);
            }
        }

        $this->addsModel->delAdsBanner($requestData['id']);

        throw new DelSuccessMsgException();
    }


}