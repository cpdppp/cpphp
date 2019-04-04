<?php
namespace core\lib;
use core\lib\conf;
class route
{
    public function __construct()
    {
        //xxx.com/index/index;
        /**
         * 1.隐藏index.php
         * 2.获取URL参数部分
         * 3.返回对应控制器和方法
        */
        if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/' ) {
            //index/index
            $path = $_SERVER['REQUEST_URI'];
            $patharr = explode('/',trim($path,'/'));
            if(isset($patharr[0])) {
                $this->ctrl =$patharr[0];
                unset($patharr[0]);     //便于①分割url[参数=>值]
            }
            if(isset($patharr[1])) {
                $this->action =$patharr[1];     
                unset($patharr[1]);    //便于①分割url[参数=>值]
            } else {
                $this->action = Conf::get( 'route','ACTION');
            }
            //①url多余部分转换成GET
            //id/1/str/2/test3
            $count = count($patharr) + 2; //上一步unset掉了两个值，如不加2，键值会从2开始
            $i = 2;
            while($i < $count) {
                if(isset($patharr[$i + 1])) {   //加1防止奇数bug
                    $_GET[$patharr[$i]] = $patharr[$i + 1];
                }
                $i = $i + 2;
            }
        } else {
            $this->ctrl = conf::get('route', 'CTRL');
            $this->action = conf::get( 'route','ACTION');
        }
    }
}