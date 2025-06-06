<?php

namespace Admin\Controller;

use Think\Controller;

class RecruitController extends CommonController
{
    function _initialize()
    {
        parent::_initialize();
    }

    //     public function index(){
    //         $count = M('article')->where('menu_id=13 and status=2')->count();
    //         $Page  = new \Think\Page($count, 20);
    //         $Page->setConfig('prev', '上一页');
    //         $Page->setConfig('next', '下一页');
    //         $Page->setConfig('last', '末页');
    //         $Page->setConfig('first', '首页');
    //         $Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
    //         $page  = $Page->show();
    //         $list =  M('article')->where('menu_id=13 and status=2')->order('sort asc')->limit($Page->firstRow.','.$Page->listRows)->select();
    //         for($i=0;$i<count($list);$i++){
    // //            if( mb_strlen($list[$i]['abstract'],'utf-8')>120){
    // //                $list[$i]['abstract'] = mb_substr($list[$i]['abstract'],0,120,'utf-8').". . .";
    // //            }
    // //            $list[$i]['year'] = date('Y',strtotime($list[$i]['create_time']));
    // //            $list[$i]['data'] = date('m.d',strtotime($list[$i]['create_time']));
    //         }
    //         $this->assign("page", $page);
    //         $this->assign('list',$list);
    //         $this->display();
    //     }

    //     public function idea(){
    //         $this->display();
    //     }

    //     public function training(){
    //         $this->display();
    //     }
    // -----------------------------------------------------------------------------------------------------------
    // 人力资源->人才理念
    public function concept()
    {
        $this->display();
    }
    
    // 人力资源->员工风采
    public function staff()
    {
        $staff = M('staff');
        $count = M('pic_dir')->where("status=1")->count();
        $Page  = new \Think\Page($count, 24);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        // $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $page  = $Page->show();
        $list = M('pic_dir')->limit($Page->firstRow . ',' . $Page->listRows)->where(array('status' => 1))->order('sort asc,id asc,update_time desc')->select();
        foreach ($list as $key => $val) {
            $list[$key]['url'] = $staff->where(array('pid' => $val['id'], 'is_cover' => 1))->getField('url');
        }
        $this->assign('page', $page);
        $this->assign('list', $list);
        $this->display();
    }
    // 人力自营->员工风采->员工相册
    public function staff_album()
    {
        $url = $_GET['url'];
        $pid = I("get.id");
        $list = M('staff')->where(array('status' => 1, 'pid' => $pid))->order('sort asc')->select();
        $title = M('pic_dir')->where(array('id' => $pid))->getField('title');
        $create_time = M('pic_dir')->where(array('id' => $pid))->getField('create_time');
        $this->assign('create_time', $create_time);
        $this->assign('list', $list);
        $this->assign('title', $title);
        $this->display();
    }

    // 人力资源->精信大讲堂
    public function study()
    {
        $count = M('article')->where('menu_id=90 and status=2')->count();
        $Page  = new \Think\Page($count, 10);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
        $page  = $Page->show();
        $list =  M('article')->where('menu_id=90 and status=2')->order('article_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        for ($i = 0; $i < count($list); $i++) {
            if (mb_strlen($list[$i]['abstract'], 'utf-8') > 120) {
                $list[$i]['abstract'] = mb_substr($list[$i]['abstract'], 0, 120, 'utf-8') . ". . .";
            }
            if ($list[$i]['article_time'])
                $list[$i]['create_time'] = $list[$i]['article_time'];
            $list[$i]['year'] = date('Y', strtotime($list[$i]['create_time']));
            $list[$i]['data'] = date('m-d', strtotime($list[$i]['create_time']));

            $fileId = isset($list[$i]['file_id']) ? intval($list[$i]['file_id']) : 0;
                if ($fileId > 0) {
                    $list[$i]['news_img'] = M('file')->where(['id' => $fileId])->getField('file_path');
                } else {
                    $list[$i]['news_img'] = ''; // 或者设置为默认图片路径
                }
        }

        

        $this->assign("page", $page);
        $this->assign('list', $list);
        $this->display();
    }


    // 人力资源->精信大讲堂具体内容
    public function study_detail()
    {
        $info = M('article')->where('id=' . $_GET['id'])->find();

        // 统计点击量
        $save['clicks'] = $info['clicks'] + 1;
        M('article')->where('id='.$_GET['id'])->save($save);

        if ($info['file_id']) {
            $info['pic_info'] = M('file')->where('id=' . $info['file_id'])->find();
        }
        if ($info['article_time']) {
            $info['create_time'] = $info['article_time'];
        } else {
            $info['article_time'] = "0000-00-00 00:00:00";
        }

        $info['year'] = date('Y', strtotime($info['create_time']));
        $info['date'] = date('m.d', strtotime($info['create_time']));

        // $top_id = M('article')->where('menu_id='.$info['menu_id'].' and status=2')->order('article_time desc,id desc')->limit('1')->getField('id');
        $prev = M('article')->where('menu_id=' . $info['menu_id'] . ' and status=2 and article_time>"' . $info['article_time'] . '"')->order('article_time asc,id asc')->limit('1')->getField('id');
        $next = M('article')->where('menu_id=' . $info['menu_id'] . ' and status=2 and article_time < "' . $info['article_time'] . '"')->order('article_time desc,id desc')->limit(1)->getField('id');

        if ($prev) {
            $prev_id = $prev;
        } else {
            $prev_id = 0;
        }

        if ($next) {
            $next_id = $next;
        } else {
            $next_id = 0;
        }
        switch ($info['menu_id']) {
            case 19:
                $back_url = __APP__ . "/index.php/Admin/News/index";
                break;
            case 20:
                $back_url = __APP__ . "/index.php/Admin/News/notice";
                break;
            case 21:
                $back_url = __APP__ . "/index.php/Admin/News/trends";
                break;
            case 22:
                $back_url = __APP__ . "/index.php/Admin/News/focus";
                break;
        }

        $info['post_time'] = substr($info['article_time'], 0, 16);
        $this->assign('prev_id', $prev_id);
        $this->assign('next_id', $next_id);
        $this->assign('back_url', $back_url);
        $this->assign('info', $info);
        $this->display();
    }


    // 人力资源->招贤纳士
    public function recruit()
    {
        $position_mapping = array(
            1 => "武汉市",
            2 => "襄阳市",
            3 => "黄冈市",
            4 => "荆州市",
            5 => "宜昌市",
            6 => "孝感市",
            7 => "十堰市",
            8 => "荆门市",
            9 => "黄石市",
        );
        $map['status'] = 2;
        if($_POST['submit_pos_data']!=""){
            $map['pos_id'] = $_POST['submit_pos_data'];
        }
        if($_POST['search-job']!=""){
            $query = '%'.$_POST['search-job'].'%';
            $map['job'] = array('like', $query);
        }
        if($_POST['submit_kind_data']!=""){
            $map['kind'] = $_POST['submit_kind_data'];
        }
        // if($_POST['submit_pos_data']!=""){
        //     $query = $_POST['submit_pos_data'].'%';
        //     $map['kind'] = $_POST['submit_data'];
        // }
        
        // $res = M('recruit')->where($map)->select();
        $count = M('recruit')->where($map)->count();
        $Page  = new \Think\Page($count, 5);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
        $page  = $Page->show();
        $list =  M('recruit')->where($map)->order('recruit_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $pos_list = M('recruit')->Distinct(true)->field('pos_id')->select();
        
        foreach ($pos_list as $key => $val) {
            $pos_list[$key]['pos_name'] = $position_mapping[$val['pos_id']];
        }

        
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('pos_list', $pos_list);
        $this->display();
    }

    public function recruit_detail()
    {
        $info = M('recruit')->where('id=' . $_GET['id'])->find();

        $prev_id = null;
        $next_id = null;
        $back_url = null;

        $this->assign('prev_id', $prev_id);
        $this->assign('next_id', $next_id);
        $this->assign('back_url', $back_url);
        $this->assign('info', $info);
        $this->display();
    }

    // 精信大讲堂
    public function promotion()
    {   
        $top_study = M('article')->where('menu_id=90 and status=2 and top=1')->order('sort asc, article_time desc')->select();
        foreach ($top_study as $key => $val) {
            $top_study[$key]['date'] = substr($val['article_time'],0,10);

            if ($top_study[$key]['article_time'])
            $top_study[$key]['create_time'] = $top_study[$key]['article_time'];
            $top_study[$key]['year'] = date('Y', strtotime($top_study[$key]['create_time']));
            $top_study[$key]['data'] = date('m-d', strtotime($top_study[$key]['create_time']));
            $fileId = $top_study[$key]['file_id'];
                if (!empty($fileId)) {
                    $top_study[$key]['news_img'] = M('file')->where(['id' => $fileId])->getField('file_path');
                } else {
                    $top_study[$key]['news_img'] = ''; // 或默认图片路径
                }
        }
        $this->assign('top_study_list', $top_study);
        $this->display();
    }

    // 人力资源->薪酬福利
    public function salary()
    {
        $this->display();
    }
}
