<?php
namespace Admin\Controller;
use Think\Controller;

class ContactController extends CommonController
{
    function _initialize(){
        parent::_initialize();
    }

    // public function index(){
    //     $this->display();
    // }
    // ------------------------------------------------------------------------------------
    public function contact(){
        $this->display();
    }

}


