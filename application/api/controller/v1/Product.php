<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/24
 * Time: 11:05
 */

namespace app\api\controller\v1;

use app\api\model\Product as productModel;
use app\api\validate\CountValidate;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\MobileValidate;
use app\lib\exception\ProductMissException;
use curl\Curl\Curl;
use think\Controller;
use think\Loader;

class Product extends Controller
{
    protected $crmTestUrl = "";
    protected $curl = "";

    public function __construct()
    {
        parent::__construct();
        Loader::import('curl.Curl');
        $this->curl = new Curl();
        $this->crmTestUrl = config('setting.crm_test');
    }

    public function getRecentGoods($count = 15)
    {
        (new CountValidate())->goCheck();

        $recetDaat = productModel::getRcenntGoods($count);

        if (!$recetDaat) {
            throw new ProductMissException();
        }

        return json($recetDaat);
    }

    // 获取登录信息
    public function getInfo()
    {
        $authtoken['authtoken'] = '4b984c630d0c464598bf23dd73e636a3';
        $registerUrl = $this->crmTestUrl . 'app/thirdparty/getLoginInfo';
        //echo $registerUrl;die;
        $this->curl->set('CURLOPT_HTTPHEADER', array('Content-Type' => 'application/x-www-form-urlencoded'))
            ->post(http_build_query($authtoken))->url($registerUrl);
        
        $content = $this->curl->data();

        if (is_null(json_decode($content))) {
            var_export($content);
        } else {
            return $content;
        }
    }

    // 获取是否是会员
    public function getIsMember()
    {
        $authtoken['authtoken'] = '4b984c630d0c464598bf23dd73e636a3';
        $registerUrl = $this->crmTestUrl . 'app/thirdparty/getMemberInfo';
        //echo $registerUrl;die;
        $this->curl->set('CURLOPT_HTTPHEADER', array('Content-Type' => 'application/x-www-form-urlencoded'))
            ->post(http_build_query($authtoken))->url($registerUrl);

        $content = $this->curl->data();

        if (is_null(json_decode($content))) {
            var_export($content);
        } else {
            return $content;
        }
    }

    /**
     * [getUserInfo 1.1.获取用户登录资料]
     */
    public function getUserInfo()
    {
        //phpinfo();die;
        $data = [
            'password' => base64_encode('ab345678'),
            'loginname' => base64_encode('15000696715'),
        ];


        $str = json_encode($data);

        //ab -t 60 -c 100 http://scgh.lilisou.com/app/thirdparty/getLoginInfo?authtoken=32a99e8b26724cf2a87aaa45a30401e0

        //ab -n 500 -c 500 http://local.o2o.com/api/v1/Product/user
        //-n发出800个请求，-c模拟800并发，相当800人同时访问，后面是测试url
        //
        //ab -t 60 -c 100 http://local.o2o.com/api/v1/Product/user
        //在60秒内发请求，一次100个请求。 
        //

        //$postData['p'] = base64_encode($this->mcrypt_des_cbc_pkcs5padding($str,'7588028820109132570743325312898426347857298773549468758875018579537757772163084478873699447306034466200616411960574122434059469100235892702736860872901247123345'));

        //dump($postData);die;
        $registerUrl = $this->crmTestUrl . 'app/thirdparty/login';

        $this->curl->post(http_build_query($data))->url($registerUrl);

        $content = $this->curl->data();

        if (is_null(json_decode($content))) {
            var_export($content);
        } else {
            return $content;
        }

    }

    /**
     * [doRegister 注册用户]
     */
    public function doRegister()
    {

        $data = [
            'mobile' => '13382322040',
            'captcha' => '292517',
            'password' => base64_encode('abcd1234'),
            'city' => '淮安市',
            'province' => '江苏省',
            'longitude' => '',
            'latitude' => '',
            'authtoken' => '150fe66e2a754752b4e6c7802b4d5200'
        ];

        $registerUrl = $this->crmTestUrl . 'app/application/registry';

        $this->curl->set('CURLOPT_HTTPHEADER', array('Content-Type' => 'application/x-www-form-urlencoded'))->post(http_build_query($data))->url($registerUrl);

        $content = $this->curl->data();

        if (is_null(json_decode($content))) {
            var_export($content);
        } else {
            return $content;
        }
    }

    //发送短信
    public function sendSmsCode($mobile)
    {
        (new MobileValidate())->goCheck();
        $sendUrl = $this->crmTestUrl . 'app/application/captcha?mobile=' . $mobile;

        //http://scgh.lilisou.com/app/application/captcha?mobile=13382322040

        $this->curl->url($sendUrl);
        $content = $this->curl->data();

        //$content = '{"data":{"authtoken":"5cc72bef660a45a583ceee33fbd01e0b"},"code":200,"msg":""}';

        if (is_null(json_decode($content))) {

            var_export($content);
        } else {
            return $content;
        }
    }

    public function StrToBin($str)
    {
        $arr = preg_split('/(?<!^)(?!$)/u', $str);
        foreach ($arr as &$v) {
            $temp = unpack('H*', $v);
            $v = base_convert($temp[1], 16, 2);
            unset($temp);
        }
        return join(' ', $arr);
    }

    /**
     * [getIdTodetails      得到商品id  去获取商品的详情]
     * @param   string $productId 商品id
     * @return  $data       json        这个商品的详情
     */
    public function getIdTodetails($id = "")
    {

        (new IDMustBePositiveInt())->goCheck();

        $data = productModel::getIdToDatails($id);

        if (empty($data)) {
            throw new ProductMissException();
        }

        return json($data);
    }
}