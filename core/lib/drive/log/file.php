<?php
namespace core\lib\drive\log;
use core\lib\conf;
    //文件系统
class file 
{
    public $path; //日志存储位置
    public function __construct()
    {
        $conf = conf::get('log','OPTION');
        $this->path = $conf['PATH'];
    }
    public function log($msg, $file = 'log')
    {
        /**
         * 1.新建文件存储位置是否存在
         *  新建目录
         * 2.写入日志
        */
        if(!is_dir($this->path.date('YmdH'))) {
            mkdir($this->path.date('YmdH'),0777,true);
        }
        return file_put_contents($this->path.date('YmdH').'/'.$file.'.php',date('Y-m-d H:i:s ').json_encode($msg).PHP_EOL,FILE_APPEND);   //写入日志文件
    }
}