<?php

namespace Admin\Controller;

use Think\Controller;

class AboutController extends CommonController
{
    function _initialize()
    {
        parent::_initialize();
    }

    public function introduce()
    {
        $url = CONTROLLER_NAME . "/" . ACTION_NAME;
        $info = M('content')->where(array('status' => 2, 'url' => $url))->getField('content');
        $this->assign('info', $info);
        $this->display();
    }
    public function index()
    {
        $url = CONTROLLER_NAME . "/" . ACTION_NAME;
        $info = M('content')->where(array('status' => 2, 'url' => $url))->getField('content');
        $this->assign('info', $info);
        $this->display();
    }

    // public function leader(){
    //     $this->display();
    // }

    // public function leader2(){
    //     $this->display();
    // }

    // public function framework(){
    //     $this->display();
    // }

    // public function team(){
    //     $this->display();
    // }

    // public function team2(){
    //     $this->display();
    // }

    // public function honor(){
    //     $url=CONTROLLER_NAME."/".ACTION_NAME;
    //     $info=M('content')->where(array('status'=>2,'url'=>$url))->getField('content');
    //     $this->assign('info',$info);
    //     $this->display();
    // }

    // public function culture(){
    //     $this->display();
    // }

    // public function care(){
    //     $url=CONTROLLER_NAME."/".ACTION_NAME;
    //     $info=M('content')->where(array('status'=>2,'url'=>$url))->getField('content');
    //     $this->assign('info',$info);
    //     $this->display();
    // }

    // public function staff(){
    //     // if(isset($_REQUEST['p'])){
    //     //     $this->display('staff_2');
    //     // }else{
    //     //     $this->display();
    //     // }
    //     $staff=M('staff');
    //     $count=M('pic_dir')->where("status=1")->count();
    //     $Page  = new \Think\Page($count, 9);
    //     $Page->setConfig('prev', '上一页');
    //     $Page->setConfig('next', '下一页');
    //     $Page->setConfig('last', '末页');
    //     $Page->setConfig('first', '首页');
    //     // $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
    //     $page  = $Page->show();
    //     $list = M('pic_dir')->limit($Page->firstRow.','.$Page->listRows)->where(array('status'=>1))->order('sort asc,id asc,update_time desc')->select();
    //     foreach($list as $key => $val){
    //         $list[$key]['url']=$staff->where(array('pid'=>$val['id'],'is_cover'=>1))->getField('url');
    //     }
    //     $this->assign('page',$page);
    //     $this->assign('list',$list);
    //     $this->display();
    // }

    // public function staff_album(){
    //     // $url = $_GET['url'];
    //     $pid=I("get.id");
    //     $list=M('staff')->where(array('status'=>1,'pid'=>$pid))->order('sort asc')->select();
    //     $this->assign('list',$list);
    //     $this->display();
    // }

    // public function staff_detail(){
    //     $url = $_GET['url'];
    //     $this->display($url);
    // }
    // -------------------------------------------------------------------------------------------------------------
    // 走进精信->精信简介
    // public function introduce()
    // {
    //     $url = CONTROLLER_NAME . "/" . ACTION_NAME;
    //     $info = M('content')->where(array('status' => 2, 'url' => $url))->getField('content');
    //     $this->assign('info', $info);
    //     $this->display();
    // }
    // 走进精信->精信简介
    public function development()
    {
        $this->display();
    }
    // 走进精信->精信简介
    public function honor()
    {
        // $url=CONTROLLER_NAME."/".ACTION_NAME;
        // $info=M('content')->where(array('status'=>2,'url'=>$url))->getField('content');
        // $this->assign('info',$info);
        $this->display();
    }
    // 走进精信->精信简介
    public function culture()
    {
        $this->display();
    }
    // 走进精信->精信月刊
    public function magazine()
    {
        $count = M('magazine')->where(array('status' => 1))->count();
        $Page  = new \Think\Page($count, 9);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
        $page  = $Page->show();
        $list = M('magazine')->where(array('status' => 1))->limit($Page->firstRow.','.$Page->listRows)
        ->order('sort asc,date DESC')->select();
        // $list = M('magazine')->where(array('status' => 1))->order('date DESC')->select();
        // 将 date 字段格式化为 yyyy年m月
        foreach ($list as $key => $val) {
            if (!empty($list[$key]['date'])) {
                $dateObj = new \DateTime($list[$key]['date']);
                $list[$key]['date'] = $dateObj->format('Y年n月');
                $fileId = $list[$key]['file_id'];
                if (!empty($fileId)) {
                    $list[$key]['news_img'] = M('file')->where(['id' => $fileId])->getField('file_path');
                } else {
                    $list[$key]['news_img'] = ''; // 或默认图片路径
                }
            }
        }
        $list_top = M('magazine')->where(array('status' => 1))->order('sort asc,date DESC')->limit(1)->select();
        // $list = M('magazine')->where(array('status' => 1))->order('date DESC')->select();
        // 将 date 字段格式化为 yyyy年m月
        foreach ($list_top as $key => $val) {
            if (!empty($list_top[$key]['date'])) {
                $dateObj = new \DateTime($list_top[$key]['date']);
                $list_top[$key]['date'] = $dateObj->format('Y年n月');
                $fileId = $list_top[$key]['file_id'];
                if (!empty($fileId)) {
                    $list_top[$key]['news_img'] = M('file')->where(['id' => $fileId])->getField('file_path');
                } else {
                    $list_top[$key]['news_img'] = ''; // 或默认图片路径
                }
            }
        }

        $this->assign('page',$page);
        $this->assign('list', $list);
        $this->assign('list_top', $list_top);
        $this->display();
    }
}
