<?php
namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller
{
    public function login(){
//        var_dump(session());
        $this->display('login');
    }

    public function ajaxLogin(){
        //session_start();
        $user_name = I("post.user_name");
        $user_pwd  = I("post.user_pwd", "", "md5");
        $User = M("user");
        $where['name'] = $user_name;
        $where['status'] = 1;

        $data = $User->where($where)->find();
        $ret['code'] = 1;
        $ret['role'] = $data['role'];
        if(empty($data)){
            $ret['code']  = 2;
            $ret['error'] = "用户名不存在";
        }else if($data['pwd'] != $user_pwd){
            $ret['code']  = 2;
            $ret['error'] = "密码错误";
        }else{
            session("user", $data);
            R('Home/Common/writeLog',array("用户登录"));
        }
        echo json_encode($ret);
    }

}


?>