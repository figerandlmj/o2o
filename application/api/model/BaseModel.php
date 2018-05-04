<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/9/3
 * Time: 16:12
 */

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    /**
     * [getUrlAttr 读取器的使用] 因为所有的图片不一定都是本地
     * @param $value
     */
    protected function getFixImagPath($value, $data)
    {
        $imgPath = $value;
        if ($data['from'] == '1') {
            $imgPath = config('setting.img_path') . '/images'.$value;
        }
        return $imgPath;
    }
}