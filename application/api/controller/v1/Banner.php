<?php

namespace app\api\controller\v1;

use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;
use think\Controller;

class Banner extends Controller
{
    /**
     * [getBanner 获取指定id的banner信息]
     * @param string $id [banner的id号]
     * @param array $data
     * @url    /banner/:id
     * @return string []
     */
    public function getBanner($id = "")
    {
        (new IDMustBePositiveInt())->goCheck();

        $banner = BannerModel::getBannerById($id);

        if (!$banner) {
            throw new BannerMissException();//内部错误
        }

        return $banner;
    }


    public function getInsert()
    {
        //$data = Db::table('wp_sign_data')->select();

//        select uid from wp_sign_data
//	where sign_date BETWEEN 1501430400 and 1501948799
//		group by uid having count(id) =6;
//
//select uid from wp_sign_data
//	where sign_date BETWEEN 1502035200 and 1502553599
//		group by uid having count(id) =6;

        $where = [
            ['start' => '1501430400', 'end' => '1501948799', "weekDayStart" => "1501948800", "weekDayEnd" => "1502035199"],//第一周
            ['start' => '1502035200', 'end' => '1502553599', "weekDayStart" => "1502553600", "weekDayEnd" => "1502639999"],//第二周
            ['start' => '1502640000', 'end' => '1503158399', "weekDayStart" => "1503158400", "weekDayEnd" => "1503244799"],//第三周
            ['start' => '1503244800', 'end' => '1503763199', "weekDayStart" => "1503763200", "weekDayEnd" => "1503849599"],//第四周
        ];

        $filer = [
            ['start' => '1501430400', 'end' => '1501948799', "weekDayStart" => "1501948800", "weekDayEnd" => "1502035199"],//第一周
        ];
    }
}


