<?php
/*
*入口文件
*1.定义常量
*2.加载函数库
*3.启动框架
*/
define('CPPHP',realpath('./'));
define('CORE',CPPHP.'/core');
define('APP',CPPHP.'/app');
define('CONFIG_DIR', CPPHP.'/core/config');
define('MODULE','app');

include "vendor/autoload.php";
define('DEBUG',true);

if(DEBUG) {
	//ini_set('display_error', 'On');
	$whoops = new \Whoops\Run;
	$errorTitle = '框架出错了！';
	$option = new \Whoops\Handler\PrettyPageHandler();
	$option->setPageTitle($errorTitle);
	$whoops->pushHandler($option);
	$whoops->register();
} else {
	ini_set('display_error', 'Off');
}

include CORE.'/common/function.php';
include CORE.'/cpphp.php';
spl_autoload_register('\core\cpphp::load');//加载不存在的类
\core\cpphp::run();