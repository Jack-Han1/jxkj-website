<?php
namespace Admin\Controller;
use Think\Controller;

class IndustryController extends CommonController
{
    function _initialize(){
        parent::_initialize();
    }
    // 产业布局->通讯业务
    public function communicate(){
        $this->display();
    }
    // 产业布局->智慧校园
    public function campus(){
        $this->display();
    }
    // 产业布局->光伏电能
    public function energy(){
        $this->display();
    }
    // 产业布局->智慧城管
    public function urban(){
        $this->display();
    }

}


