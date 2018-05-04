<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/9/4
 * Time: 10:02
 */

namespace app\api\controller\v1;

use app\api\validate\IDCollectionStrs;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;
use think\Controller;
use app\api\Model\Theme as ThemeModel;
use think\Db;

class Theme extends Controller
{

    /**
     * [getSimpleTheme ]
     * @param string $id
     * @url  /Theme/getSimpleTheme/id=1,2,3
     */
    public function getSimpleTheme($id = "")
    {
        (new IDCollectionStrs())->goCheck();
        $ids = explode(',', $id);

        $result = ThemeModel::getSimpleIdsToInfos($ids);

        if (empty($result)) {
            throw new ThemeException();
        }

        return json($result);
    }

    public function getComplexOne($id)
    {
        (new IDMustBePositiveInt())->goCheck($id);

        $result = ThemeModel::getThmemProducts($id);

        if (empty($result)) {
            throw new ThemeException();
        }

        return json($result);
    }


    //翼支付
    public function updateFirtyCard()
    {
        //查出 wp_lucky_follow 表中有的  但 wp_uid_firtycard表中没有的
        $sql = "select * from wp_lucky_follow  where follow_id not in (select uid from wp_uid_firtycard) and    `award_id` = '27'";
        $data = db::query($sql);
        //dump($data);die;
        //$arr= array();
        foreach ($data as $key => $val) {
            //从wp_firty_cardno 取出 status=0 
            $sql = "select * from wp_firty_cardno where status='0' limit 1;";
            $firtyData =  db::query($sql);
            $time = $val['zjtime'];
            //把上面的那条 status = 1
            if(!empty($firtyData)){
                echo "update wp_firty_cardno set status='1',updatetime='".$time."' where id='".$firtyData['0']['id']."';"."<br/>";
            }

            //把uid 卡号id  卡号 卡密 插入 wp_uid_firtycard
            echo "insert into wp_uid_firtycard(`uid`,`firtyCardnoid`,`cardNo`,`cardPwd`) values('{$val['follow_id']}','{$firtyData['0']['id']}','{$firtyData['0']['cardno']}','{$firtyData['0']['cardPwd']}');"."<br/>";

            //把中奖信息 udi  award_id='27' type='1' firtyCardNo firtyCardPwd 
            //createtime updateTime 插入到wp_winning_records
            echo "insert into wp_winning_records(`uid`,`award_id`,`type`,`firtyCardNo`,`firtyCardPwd`,`createtime`,`updateTime`) values('{$val['follow_id']}','27','1','{$firtyData['0']['cardno']}','{$firtyData['0']['cardPwd']}','{$time}','{$time}');"."<br/>";
            die;
        }
    }

    //88
    public function updateEnghtStatus()
    {
        //查出88共享 wp_lucky_follow 表中有的  但 wp_uid_firtycard表中没有的
        $sql = "select * from wp_lucky_follow  where follow_id not in (select uid from wp_winning_records) and  `award_id` = '29'";
        $data = db::query($sql);

        foreach ($data as $key => $val) {
            
            //插入wp_winning_records b表中 award_id=29  type 3  createtime
            echo "insert into `wp_winning_records`(`uid`,`award_id`,`type`,`createtime`) values('{$val['follow_id']}','29','3','{$val['zjtime']}');"."<br/>";
        }
    }

    //积分
    public function updateGrateStatus()
    {
        //查出88共享 wp_lucky_follow 表中有的  但 wp_uid_firtycard表中没有的
        $sql = "select * from wp_lucky_follow  where follow_id not in (select uid from wp_winning_records) and  `award_id` = '30'";
        $data = db::query($sql);

        foreach ($data as $key => $val) {
            //插入wp_winning_records b表中 award_id=29  type 3  createtime
            echo "insert into `wp_winning_records`(`uid`,`award_id`,`type`,`createtime`) values('{$val['follow_id']}','30','3','{$val['zjtime']}');"."<br/>";
        }
    }
    
}