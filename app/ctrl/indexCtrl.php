<?php
namespace app\ctrl;
use app\model\guestbookModel;
class indexCtrl extends \core\cpphp
{
    /* 类名和方法名一样时，这个方法会被定义为初始化方法；
        cpphp为防止上述情况,定义控制器时，添加CTRL后缀； */

    //所有留言
    public function index()
    {
        $model = new guestbookModel();
        $data = $model->getAll();
        $this->assign('data',$data);
        $this->display('index.html');
    }
    //添加留言
    public function add()
    {
        $this->display('add.html');
    }
    //保存留言
    public function save()
    {
        $data['title'] = post('title','int');
        $data['content'] = post('content');
        $model = new \app\model\guestbookModel();
        $res = $model->addOne($data);
        if($res) {
            p('ok');
        } else {
            p('error');
        }
    }
    public function del()
    {
        $id = get('id', 0 , 'int');    
        if($id) {
            $model = new guestbookModel();
            $res = $model->delOne($id);
            if($res) {
                redirect('/');
            } else {
                exit('删除失败');
            }
        } else {
            exit('参数错误');
        }
    }
}