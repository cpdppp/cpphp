<?php
namespace core;
class cpphp
{
    
    public static $classMap = array();//把已经加载的类放入数组；
    //控制器的实现
    public $assign;
    public static function run() 
    {
        /**
         *测试日志功能
         * \core\lib\log::init();
         * \core\lib\log::log($_SERVER,'server');
        */
        $route = new \core\lib\route();
        $ctrlClass = $route->ctrl;
        $action = $route->action;
        $ctrlfile = APP.'/ctrl/'.$ctrlClass.'Ctrl.php';
        $ctrlClass = '\\'.MODULE.'\ctrl\\'.$ctrlClass.'Ctrl';
        if(is_file($ctrlfile)) {
            include $ctrlfile;
            $ctrl = new $ctrlClass();
            $ctrl->$action();
           //   \core\lib\log::log('ctrl:'.$route->ctrl.';'.'action:'.$route->action);    //记录每次访问的控制器及方法
        } else {
            throw new \Exception('找不到控制器'.$ctrlClass);
        }
    }
    //自动加载类库
    public static function load($class)
    {
        if(isset(self::$classMap[$class])) {
            return true;
        } else {
            $class = str_replace('\\','/',$class);
            $file = CPPHP.'/'.$class.'.php';
            if(is_file($file)) {
                include $file;
                self::$classMap[$class] = $class;
            } else {
                return false;
            }
        }
    }
    //视图变量方法
    public function assign($name, $data)
    {
        $this->assign[$name] = $data;
    }
    //试图输出方法 
    public function display($file, $data=array())
    {
          if(is_file(APP.'/views/'.$file)) {
            $loader = new \Twig_Loader_Filesystem(APP.'/views');
            $twig = new \Twig_Environment($loader, array(
                'cache' =>  CPPHP.'/log/twig',
                'debug' => DEBUG,   //调试模式下没有浏览器缓存cache' => BASE_DIR.'/log/cache',
            ));
            //$twig->display($file, $data);
            $template = $twig->loadTemplate($file);
            $template->display($this->assign ? $this->assign : []);
        } else {
            if(DEBUG) {
                throw new \Exception($file.'是一个不存在的模板文件');
            } else {
                show404();
            }
        } 
    } 
}