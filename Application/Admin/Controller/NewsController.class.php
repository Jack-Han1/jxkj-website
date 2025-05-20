<?php

namespace Admin\Controller;

use Think\Controller;

class NewsController extends CommonController
{
    function _initialize()
    {
        parent::_initialize();
    }

    // public function index(){
    //     $count = M('article')->where('menu_id=19 and status=2')->count();
    //     $Page  = new \Think\Page($count, 10);
    //     $Page->setConfig('prev', '上一页');
    //     $Page->setConfig('next', '下一页');
    //     $Page->setConfig('last', '末页');
    //     $Page->setConfig('first', '首页');
    //     $Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
    //     $page  = $Page->show();
    //     $list =  M('article')->where('menu_id=19 and status=2')->order('article_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    //     for($i=0;$i<count($list);$i++){
    //         if( mb_strlen($list[$i]['abstract'],'utf-8')>120){
    //             $list[$i]['abstract'] = mb_substr($list[$i]['abstract'],0,120,'utf-8').". . .";
    //         }
    //         if($list[$i]['article_time'])
    //             $list[$i]['create_time'] = $list[$i]['article_time'];
    //         $list[$i]['year'] = date('Y',strtotime($list[$i]['create_time']));
    //         $list[$i]['data'] = date('m.d',strtotime($list[$i]['create_time']));
    //     }

    //     $this->assign("page", $page);
    //     $this->assign('list',$list);
    //     $this->display();
    // }

    // public function notice(){
    //     $count = M('article')->where('menu_id=20 and status=2')->count();
    //     $Page  = new \Think\Page($count, 20);
    //     $Page->setConfig('prev', '上一页');
    //     $Page->setConfig('next', '下一页');
    //     $Page->setConfig('last', '末页');
    //     $Page->setConfig('first', '首页');
    //     $Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
    //     $page  = $Page->show();
    //     $list =  M('article')->where('menu_id=20 and status=2')->order('top desc,article_time desc,create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    //     for($i=0;$i<count($list);$i++){
    //         if( mb_strlen($list[$i]['abstract'],'utf-8')>120){
    //             $list[$i]['abstract'] = mb_substr($list[$i]['abstract'],0,120,'utf-8').". . .";
    //         }
    //         if($list[$i]['article_time'])
    //             $list[$i]['create_time'] = $list[$i]['article_time'];
    //         $list[$i]['year'] = date('Y',strtotime($list[$i]['create_time']));
    //         $list[$i]['data'] = date('m.d',strtotime($list[$i]['create_time']));
    //     }
    //     $this->assign("page", $page);
    //     $this->assign('list',$list);
    //     $this->display();
    // }

    // public function trends(){
    //     $count = M('article')->where('menu_id=21 and status=2')->count();
    //     $Page  = new \Think\Page($count, 20);
    //     $Page->setConfig('prev', '上一页');
    //     $Page->setConfig('next', '下一页');
    //     $Page->setConfig('last', '末页');
    //     $Page->setConfig('first', '首页');
    //     $Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
    //     $page  = $Page->show();
    //     $list =  M('article')->where('menu_id=21 and status=2')->order('top desc,article_time desc,create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    //     for($i=0;$i<count($list);$i++){
    //         if( mb_strlen($list[$i]['abstract'],'utf-8')>120){
    //             $list[$i]['abstract'] = mb_substr($list[$i]['abstract'],0,120,'utf-8').". . .";
    //         }
    //         if($list[$i]['article_time'])
    //             $list[$i]['create_time'] = $list[$i]['article_time'];
    //         $list[$i]['year'] = date('Y',strtotime($list[$i]['create_time']));
    //         $list[$i]['data'] = date('m.d',strtotime($list[$i]['create_time']));
    //     }
    //     $this->assign("page", $page);
    //     $this->assign('list',$list);
    //     $this->display();
    // }

    // public function focus(){
    //     $count = M('article')->where('menu_id=22 and status=2')->count();
    //     $Page  = new \Think\Page($count, 20);
    //     $Page->setConfig('prev', '上一页');
    //     $Page->setConfig('next', '下一页');
    //     $Page->setConfig('last', '末页');
    //     $Page->setConfig('first', '首页');
    //     $Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
    //     $page  = $Page->show();
    //     $list =  M('article')->where('menu_id=22 and status=2')->order('top desc,article_time desc,create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    //     for($i=0;$i<count($list);$i++){
    //         if( mb_strlen($list[$i]['abstract'],'utf-8')>120){
    //             $list[$i]['abstract'] = mb_substr($list[$i]['abstract'],0,120,'utf-8').". . .";
    //         }
    //         if($list[$i]['article_time'])
    //             $list[$i]['create_time'] = $list[$i]['article_time'];
    //         $list[$i]['year'] = date('Y',strtotime($list[$i]['create_time']));
    //         $list[$i]['data'] = date('m.d',strtotime($list[$i]['create_time']));
    //     }
    //     $this->assign("page", $page);
    //     $this->assign('list',$list);
    //     $this->display();
    // }

    public function detail()
    {
        $info = M('article')->where('id=' . $_GET['id'])->find();
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
        $this->assign('prev_id', $prev_id);
        $this->assign('next_id', $next_id);
        $this->assign('back_url', $back_url);
        $this->assign('info', $info);
        $this->display();
    }

    // ------------------------------------------------------------------------------------------------
    // 新闻中心-企业新闻
    public function news()
    {
        $count = M('article')->where('menu_id=19 and status=2')->count();
        $Page  = new \Think\Page($count, 10);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
        $page  = $Page->show();
        $list =  M('article')->where('menu_id=19 and status=2')->order('article_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        for ($i = 0; $i < count($list); $i++) {
            if (mb_strlen($list[$i]['abstract'], 'utf-8') > 120) {
                $list[$i]['abstract'] = mb_substr($list[$i]['abstract'], 0, 120, 'utf-8') . ". . .";
            }
            if ($list[$i]['article_time'])
                $list[$i]['create_time'] = $list[$i]['article_time'];
            $list[$i]['year'] = date('Y', strtotime($list[$i]['create_time']));
            $list[$i]['data'] = date('m-d', strtotime($list[$i]['create_time']));
            if($list[$i]['file_id']){
                $list[$i]['news_img'] = M('file')->where('id=' . $list[$i]['file_id'])->getField('file_path');
            }else{
                $list[$i]['news_img'] = '';
            }
        }

        

        $this->assign("page", $page);
        $this->assign('list', $list);
        $this->display();
    }
    //  新闻中心-详情
    public function news_detail()
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

}
