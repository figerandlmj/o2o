<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/8/25
 * Time: 13:57
 */

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Loader;

class Excel extends Controller
{
    private $name = "";
    private $char = array();
    private static $obj;

    public function __construct()
    {
        parent::__construct();
        $this->name = '群发消息';
        $this->char = ['A', 'B','C','D','E','F','G','H'];
    }


    //导出excel
    public function inportExcel()
    {
        $this->name = '绑定会员数据';
        $language = ['姓名','性别','单位','会员卡号','手机号码','地址','生日'];
        Loader::import('phpexcel.PHPExcel.IOFactory');
        $objPHPExcel = new \PHPExcel();
        // 设置excel文档的属性
        $objPHPExcel->getProperties()->setCreator("admin")//创建人
        ->setLastModifiedBy("admin")//最后修改人
        ->setTitle($this->name)//标题
        ->setSubject($this->name)//题目
        ->setDescription($this->name)//描述
        ->setKeywords("数据")//关键字
        ->setCategory("Test result file");//种类

        // 开始操作excel表
        $objPHPExcel->setActiveSheetIndex(0);
        // 设置工作薄名称
        $objPHPExcel->getActiveSheet()->setTitle(iconv('gbk', 'utf-8', 'Sheet'));
        // 设置默认字体和大小
        $objPHPExcel->getDefaultStyle()->getFont()->setName(iconv('gbk', 'utf-8', ''));
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(11);

        $styleArray = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'argb' => 'ffffffff',
                )
            ),
            'borders' => array(
                'outline' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,  //设置border样式
                    'color' => array('argb' => 'FF000000'),     //设置border颜色
                )
            )
        );
        
        $count = count($language);

        //设置宽
        for ($i = 0; $i < $count; $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($i + 65))->setWidth(50);
        }
        $endChar = "A1:" . $this->char[$count - 1] . "1";

        $objPHPExcel->getActiveSheet()
            ->getStyle($endChar)
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()
            ->getStyle($endChar)
            ->getFill()
            ->getStartColor()
            ->setARGB('333399');

        for ($i = 0; $i < $count; $i++) {
            $c = chr($i + 65) . '1';
            $objPHPExcel->getActiveSheet()->setCellValue($c, $language[$i]);
        }

        $objPHPExcel->getActiveSheet()->getStyle($endChar)->applyFromArray($styleArray);

//       $sql = 'select  wb.memberName ,wb.memberCard,wb.memberIdCard ,wb.memberPhone ,wb.companyName ,wb.workAddress ,wb.familyAddress ,
//		if(wao.`type`>0,"家庭地址","工作地址") as type, wao.address ,wao.remark ,FROM_UNIXTIME(wao.createtime) as createtime
//		 from wp_bindmember wb
//		left join wp_act_order wao on wb.id = wao.member_id
//		where wao.member_id!="" and wao.createtime >"1502674500" and wao.createtime<="1503630900" limit 2;';

        $sql = "select name  ,sex ,company  ,LPAD(vipCard, 10, 0) as vipCard,mobile  ,address  ,birth   from wp_member_info where openid!=''";
       $page = Db::query($sql);
    
        for ($row = 0; $row < count($page); $row++) {
            $i = $row + 2;
            $objPHPExcel->getActiveSheet()
                ->setCellValue('A' . $i, $page[$row]['name'])
                ->setCellValue('B' . $i, $page[$row]['sex'])
                ->setCellValue('C' . $i, $page[$row]['company'])
                ->setCellValue('D' . $i, ' '.$page[$row]['cid'])
                ->setCellValue('E' . $i, $page[$row]['county'])
                ->setCellValue('F' . $i, $page[$row]['secondary_units'])
                ->setCellValue('G' . $i, $page[$row]['company'])
                ->setCellValue('H' . $i, $page[$row]['openid']);
        }

        //输出EXCEL格式
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // 从浏览器直接输出$filename
        header('Content-Type:application/csv;charset=UTF-8');
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-excel;");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition: attachment;filename="' . $this->name . '.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }
}