<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller
{
	function _initialize(){
        // var_dump($_SERVER['HTTP_HOST']);
        // exit;
        // if($_SERVER['HTTP_HOST']!="www.jingyingshenghua.com"&&$_SERVER['HTTP_HOST']!="localhost"){
        //     redirect("http://www.jingyingshenghua.com");
        // }
        $menu_where['status'] = 1;
        $menu_where['pid'] = 0;
        $menu_where['kind'] = array('lt',3);
        $menu_where['head_show'] = 1;
        $menu_list = M('menu')->where($menu_where)->order('order_by asc')->select();
        for($menu_i=0;$menu_i<count($menu_list);$menu_i++){
            $menu_where['pid'] = $menu_list[$menu_i]['id'];
            $menu_list[$menu_i]['children_list'] = M('menu')->where($menu_where)->order('order_by asc')->select();
            if($menu_list[$menu_i]['pic_id']){
                $menu_list[$menu_i]['pic_info'] = M('file')->where('id='.$menu_list[$menu_i]['pic_id'])->find();
            }
        }

        
        $this->assign('menu_list',$menu_list);
		$menu_where['status'] = 1;
        $menu_where['kind'] = array('lt',3);
        $menu_where['head_show'] = 1;

        $menu_where['pid'] = 6;
        $menu_list = M('menu')->where($menu_where)->order('order_by asc')->select();
        $this->assign('footer_list1', $menu_list);

        $menu_where['pid'] = 7;
        $menu_list = M('menu')->where($menu_where)->order('order_by asc')->select();
        $this->assign('footer_list2', $menu_list);

        $menu_where['pid'] = 8;
        $menu_list = M('menu')->where($menu_where)->order('order_by asc')->select();
        $this->assign('footer_list3', $menu_list);

        $menu_where['pid'] = 10;
        $menu_list = M('menu')->where($menu_where)->order('order_by asc')->select();
        $this->assign('footer_list4', $menu_list);

        // var_dump($menu_list[2]['children_list']);
        $keywords = "高校大数据,网络精准营销,智慧校园,智慧金融";
        $this->assign('keywords',$keywords);
        $description = "精信科技是一家通过数字化精准营销来为客户提供互联网信息服务的高新科技公司，旗下业务涉及增值业务、呼叫中心、渠道运营、业务外包、智慧高校、智慧金融、智慧城管";
        $this->assign('description',$description);

	}


}



?>