<?php 
namespace Publics\Controller;
use Think\Controller;

class LoginController extends Controller{
	public function index(){
		$this->display('login');
	}

	public function ajaxLogin(){
		$user_name = I("post.user_name");
		$user_pwd  = I("post.user_pwd", "", "md5");
		$User = M("user_info");
		$where['user_name'] = $user_name;
		
		$data = $User->where($where)->find();
		$ret[code] = 1;
		if(empty($data)){
			$ret['code']  = 2;
			$ret['error'] = "用户名不存在";
		}else if($data['user_pwd'] != $user_pwd){
			$ret['code']  = 2;
			$ret['error'] = "密码错误";
		}else{
			session("user", $data);
			R('Home/Common/writeLog',array(CONTROLLER_NAME, "login", $data['id'], "用户登录"));
		}
		echo $this->ajaxReturn($ret);
	}

	public function logout(){
		session("user", null);
		$this->display("login");
	}
}
?>