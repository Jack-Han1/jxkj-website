<?php
namespace Home\Controller;
use Think\Controller;

class LogController extends CommonController
{
    function _initialize(){
        parent::_initialize();
        $CON = M('menu')->where('url="'.CONTROLLER_NAME.'" and status=1')->find();
        $menu_list = M('menu')->where('pid='.$CON['id'].' and status=1')->order('order_by asc')->select();
        $this->assign('menu_check',$CON);
        $this->assign('menu_list',$menu_list);
    }

    public function index(){
        $count = M('log')->count();
        $Page  = new \Think\Page($count, 20);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
//        $Page->url = 'http://jingying.vipshangbao.com/index.php/Home/Log';
        $Page->setConfig('link','http://jingying.vipshangbao.com/index.php/Home/Log');

        $page  = $Page->show();
        $list =  M('log')->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        for($i=0;$i<count($list);$i++){
            $list[$i]['show_id'] = $Page->firstRow + $i + 1;
            $list[$i]['create_name'] = M('user')->where('id='.$list[$i]['create_id'])->getField('name');
        }
        $this->assign("page", $page);
        $this->assign('list',$list);
        $this->assign('action_check',CONTROLLER_NAME."/".ACTION_NAME);
        $this->display();
    }
}