<?php
namespace core\lib;
use core\lib\conf;
use \Medoo\Medoo;
class model extends Medoo
{
    public $table = '';
    public function __construct()
    {
        //加载数据库配置
        $option = conf::get('database');
        parent::__construct($option);
    }

    public function lists()
    {
        $result = $this->select($this->table,'*');
        return $result;
    }

    public function getOne($id)
    {
        $result = $this->get($this->table,'*',array(
            'id' => $id
        ));
        return $result;    
    }

    public function setOne($id,$data)
    {
        return $this->update($this->table,$data,array(
            'id' =>$id
        ));
    }

    public function delOne($id)
    {
        $res = $this->delete($this->table, array(
            'id' => $id
        ));
        if($res !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function addOne($data)
    {
        $result = $this->insert($this->table,$data);
        return $result;
    }

    public function getAll()
    {
        return $this->select($this->table,'*'); 
    }
}