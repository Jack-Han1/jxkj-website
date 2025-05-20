<?php
namespace Home\Controller;
use Think\Controller;

class MenuController extends CommonController
{
    function _initialize(){
        parent::_initialize();
        $CON = M('menu')->where('url="'.CONTROLLER_NAME.'" and status=1')->find();
        $menu_list = M('menu')->where('pid='.$CON['id'].' and status=1')->order('order_by asc')->select();
        $this->assign('menu_check',$CON);
        $this->assign('menu_list',$menu_list);
    }

    public function index(){
        $where['pid']=0;
        $where['status'] = 1;
        $where['kind']=array('lt',3);
        $list = M('menu')->where($where)->select();
        for($i=0;$i<count($list);$i++){
            $list[$i]['show_id']=$i+1;
        }
        $this->assign('list',$list);
        $this->assign('action_check',CONTROLLER_NAME."/".ACTION_NAME);
        $this->display();
    }

    public function children_list(){
        $where['pid']= $_GET['id'];
        $where['status'] = 1;
        $list = M('menu')->where($where)->select();
        for($i=0;$i<count($list);$i++){
            $list[$i]['show_id']=$i+1;
        }
        $parent_name = M('menu')->where('id='.$_GET['id'])->getField('name');
        $this->assign('list',$list);
        $this->assign('parent_name',$parent_name);
        $this->assign('action_check',CONTROLLER_NAME."/index");
        $this->display();
    }

    public function add(){
        $where['pid']=0;
        $where['status'] = 1;
        $where['kind']=array('lt',3);
        $list = M('menu')->where($where)->select();
        $this->assign('list',$list);
        $this->assign('action_check',CONTROLLER_NAME."/".ACTION_NAME);
        $this->display();
    }

    public function save(){
        if($_FILES){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg', 'doc','docx','rmvb');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传单个文件
            $info   =   $upload->upload();
            if($info) {
                $file['file_name'] = $info['menu_pic']['name'];
                $file['file_path'] = "./Uploads/" . $info['menu_pic']['savepath'] . $info['menu_pic']['savename'];
                $file['file_size'] = $info['menu_pic']['size'];
                $file['file_ext'] = $info['menu_pic']['ext'];
                $file['create_time'] = date("Y-m-d H:i:s" ,time());
                $file_id = M('file')->add($file);
                if($file_id){
                    $this->writeLog("用户上传文件:".$file_id);
                    $save['pic_id'] = $file_id;
                }
            }
        }
        $save['name'] = $_POST['name'];
        $save['pid'] = $_POST['pid'];
        $save['kind'] = $_POST['kind'];
        $save['url'] = $_POST['url'];
        $save['head_show'] = $_POST['head_show'];
        $save['order_by'] = $_POST['order_by'];
        $save['create_id'] = session('user.id');
        $save['create_time'] = date("Y-m-d H:i:s" ,time());
        $save['status'] = 1;
        $res = M('menu')->add($save);
        if($res){
            $this->writeLog("用户添加菜单:".$res);
            $this->success("添加成功","index");
        }else{
            $this->errer("添加失败！");
        }
    }

    public function edit(){
        $where['pid']=0;
        $where['status'] = 1;
        $where['kind']=array('lt',3);
        $list = M('menu')->where($where)->select();
        $this->assign('list',$list);
        $info = M('menu')->where('id='.$_GET['id'])->find();
        if($info['pic_id']){
            $info['pic_info'] = M('file')->where('id='.$info['pic_id'])->find();
        }
        $this->assign('info',$info);
        $this->display();
    }

    public function update(){
        if($_FILES){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg', 'doc','docx','rmvb');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传单个文件
            $info   =   $upload->upload();
            if($info) {
                $file['file_name'] = $info['menu_pic']['name'];
                $file['file_path'] = "./Uploads/" . $info['menu_pic']['savepath'] . $info['menu_pic']['savename'];
                $file['file_size'] = $info['menu_pic']['size'];
                $file['file_ext'] = $info['menu_pic']['ext'];
                $file['create_time'] = date("Y-m-d H:i:s" ,time());
                $file_id = M('file')->add($file);
                if($file_id){
                    $this->writeLog("用户上传文件:".$file_id);
                    $save['pic_id'] = $file_id;
                }
            }
        }
        $m_id = $_POST['m_id'];
        $save['name'] = $_POST['name'];
        $save['pid'] = $_POST['pid'];
        $save['kind'] = $_POST['kind'];
        $save['url'] = $_POST['url'];
        $save['head_show'] = $_POST['head_show'];
        $save['order_by'] = $_POST['order_by'];
        $save['create_id'] = session('user.id');
        $save['create_time'] = date("Y-m-d H:i:s" ,time());
        $res = M('menu')->where('id='.$m_id)->save($save);
        $this->writeLog("用户修改菜单:".$m_id);
        $this->success("修改成功","index");
//        $this->display('index');
    }

    public function del_img(){
        $id = $_POST['id'];
        $save['pic_id'] = NULL;
        $res = M('menu')->where('id='.$id)->save($save);
        if($res){
            $this->writeLog("用户删除文件:".$id);
            $data['status'] = 1;
            $data['info'] = "删除成功!";
        }else{
            $data['status'] = 0;
            $data['info'] = "删除失败!";
        }
        echo json_encode($data);
    }

    public function del(){
        $id = $_POST['id'];
        $save['status'] = 0;
        $res = M('menu')->where('id='.$id)->save($save);
        if($res){
            $this->writeLog("用户删除菜单:".$id);
            $data['status'] = 1;
            $data['info'] = "删除成功!";
        }else{
            $data['status'] = 0;
            $data['info'] = "删除失败!";
        }
        echo json_encode($data);
    }
}


