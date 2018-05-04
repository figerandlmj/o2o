<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/25
 * Time: 15:41
 */

namespace app\api\controller\v1;

use app\api\validate\CategoryValidate;
use app\lib\exception\CategoryNullException;
use think\Controller;
use app\api\model\Category as categoryModel;


class Category extends Controller
{
    public function getAllCategory()
    {
        $allCategory = categoryModel::getAllCategory();
        if (empty($allCategory)) {throw new CategoryNullException();}
        return json($allCategory);
    }

    public function getIdToChildren($categoryId)
    {
        //验证分类ID
        (new CategoryValidate())->goCheck();

        //得到分类id 去获取数据
        $data = categoryModel::getChildIdToData($categoryId);

        if (empty($data)) {
            throw new CategoryNullException();
        }

        return json($data);
    }
}