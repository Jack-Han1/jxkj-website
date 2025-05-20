<?php

namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller
{
    function _initialize()
    {
        //session_start();
        if (session('user.id')) {
            $this->assign('user', session('user'));
            $this->menu();
        } else {
                $this->redirect('Login/login');
        }
        //$user = session("user");
    }

    public function logout()
    {
        $this->writeLog("用户退出");
        session("user", null);
        $this->display("Login/login");
    }

    public function menu()
    {
        $user = session('user');
        $role = $user['role'];
        $menuIds = M('user_role_value')->where(array('role' => $role, 'status' => 1))->order('sort desc')->select();
        $menu = M('menu');
        $where['kind'] = 3;
        $where['pid'] = 0;
        // $where['head_show'] = array('gt',$user['role']-1);
        $where['status'] = 1;
        // var_dump($menuIds);
        foreach ($menuIds as $key => $val) {
            $where['id'] = $val['menu_id'];
            $menuList[$key]['id'] = $val['menu_id'];
            $menuList[$key]['url'] = $menu->where($where)->getField('url');
            $menuList[$key]['name'] = $menu->where($where)->getField('name');
        }
        // var_dump($menuList);
        // $nav_list = M('menu')->where($where)->order('order_by asc')->select();
        // var_dump($nav_list);
        $this->assign('nav_list', $menuList);
    }

    public function update_pwd()
    {
        $this->assign('user_name', session('user.name'));
        $this->display();
    }

    public function save_pwd()
    {
        if (md5($_POST['old_pwd']) == session('user.pwd')) {
            $save['pwd'] = md5($_POST['new_pwd']);
            $res = M('user')->where('id=' . session('user.id'))->save($save);
            if ($res) {
                $this->writeLog("用户修改密码");
                $data['status'] = 1;
                $data['info'] = "修改成功!";
            } else {
                $data['status'] = 0;
                $data['info'] = "修改失败!";
            }
        } else {
            $data['status'] = 0;
            $data['info'] = "原密码不正确!";
        }
        echo json_encode($data);
    }

//	public function checkPermission($controller_name, $action_name){
//		$user = session("user");
//		if(empty($user)) exit("用户未登录");
//		$perm = $this->getCurrentUserNode($user);
//		$thinkNode = M("think_node");
//		$map['name'] = $controller_name.'/'.$action_name;
//		$data = $thinkNode->where($map)->find();
//		if(in_array($data['id'], $perm)){
//			return true;
//		}
//		return false;
// 	}


    /**
     * [writeLog description]
     * @param  [type] $controller_name [控制器名称]
     * @param  [type] $action_name     [方法名称]
     * @param  [type] $object          [操作对象]
     * @param  [type] $descex          [操作的具体内容]
     * @param string $result [操作结果]
     * @return [type]                  [description]
     */
    public function writeLog($content)
    {
        $user = session("user");
        $data['create_id'] = $user['id'];
        $data['content'] = $content;
        $data['create_time'] = date("Y-m-d H:i:s");
        M('log')->add($data);
    }

    //获取角色菜单权限
    public function getCurrentUserNode($user)
    {
        $map['user_id'] = $user['role'];
        $mrv = M("user_role_value");
        $action = array();
        if (empty($action)) {
            $action = $mrv->where($map)->getField("action", true);
        }
        return $action;
    }

}


?>