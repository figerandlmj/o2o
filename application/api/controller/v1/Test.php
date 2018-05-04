<?php

namespace app\api\controller\v1;


use think\Controller;

class Test extends Controller
{
    public function test()
    {

        //引用做什么
        //1. PHP 的引用允许你用两个变量来指向同一个内容。意思是，当你这样做时：
        //$b = '1';
        //$a =& $b;//注: $a 和 $b 在这里是完全相同的，这并不是 $a 指向了 $b 或者相反 $a 和 $b 指向了同一个地方。
        //2.

        $a = 5;
        echo $this->foo($a);

    }

    function foo(&$var)
    {
        $var++;
        return $var;
    }

}
