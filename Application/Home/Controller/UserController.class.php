<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends CommonController
{
    function _initialize(){
        parent::_initialize();
        $CON = M('menu')->where('url="'.CONTROLLER_NAME.'" and status=1')->find();
        $menu_list = M('menu')->where('pid='.$CON['id'].' and status=1')->order('order_by asc')->select();
        $this->assign('menu_check',$CON);
        $this->assign('menu_list',$menu_list);
    }

    public function index(){
        $where['status'] = 1;
        $where['role']=array('gt',session('user.role')-1);
        $count = M('user')->where($where)->count();
        $Page  = new \Think\Page($count, 20);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $page  = $Page->show();
        $list = M('user')->where($where)->order('id desc')->select();
        for($i=0;$i<count($list);$i++){
            $list[$i]['show_id']=$i+1;
        }
        $this->assign("page", $page);
        $this->assign('list',$list);
        $this->assign('action_check',CONTROLLER_NAME."/".ACTION_NAME);
        $this->display();
    }



    public function add(){
//        $where['pid']=0;
//        $where['status'] = 1;
//        $where['kind']=array('lt',3);
//        $list = M('menu')->where($where)->select();
//        $this->assign('list',$list);
        // $pwd = rand("100000","999999");
        // $this->assign('pwd',$pwd);
        $this->assign('action_check',CONTROLLER_NAME."/".ACTION_NAME);
        $this->display();
    }

    public function save(){
        if(M('user')->where("name='".$_POST['name']."' and status=1")->count()){
            $data['status'] = 0;
            $data['info'] = "用户已存在，请更换名称!";
        }else{
            $save['name'] = $_POST['name'];
            $save['role'] = $_POST['role'];
            $save['pwd'] = md5($_POST['pwd']);
            $save['create_id'] = session('user.id');
            $save['create_time'] = date("Y-m-d H:i:s" ,time());
            $save['status'] = 1;
            $res = M('user')->add($save);
            if($res){
                $this->writeLog("用户添加账户:".$res);
                $data['status'] = 1;
                $data['info'] = "添加成功!";
            }else{
                $data['status'] = 0;
                $data['info'] = "添加失败!";
            }
        }
        echo json_encode($data);
    }

    public function del(){
        $id = $_POST['id'];
        $save['status'] = 0;
        $res = M('user')->where('id='.$id)->save($save);
        if($res){
            $this->writeLog("用户删除账户:".$id);
            $data['status'] = 1;
            $data['info'] = "删除成功!";
        }else{
            $data['status'] = 0;
            $data['info'] = "删除失败!";
        }
        echo json_encode($data);
    }

    public function reset(){
        $id = $_POST['id'];
        $pwd = 123456;
        $save['pwd'] = md5($pwd);
        $res = M('user')->where('id='.$id)->save($save);
        if($res || M('user')->where('id='.$id.' and pwd="'.$save['pwd'].'"')->count()){
            $this->writeLog("用户重置账户密码:".$id);
            $data['status'] = 1;
            $data['data'] = $pwd;
            $data['info'] = "密码重置成功!新密码为".$pwd;
        }else{
            $data['status'] = 0;
            $data['info'] = "密码重置失败!";
        }
        echo json_encode($data);
    }
}


