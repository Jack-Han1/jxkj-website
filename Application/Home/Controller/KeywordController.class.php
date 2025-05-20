<?php
namespace Home\Controller;
use Think\Controller;

class KeywordController extends CommonController
{
    function _initialize(){
        parent::_initialize();
        $CON = M('menu')->where('url="'.CONTROLLER_NAME.'" and status=1')->find();
        $menu_list = M('menu')->where('pid='.$CON['id'].' and status=1')->order('order_by asc')->select();
        $this->assign('menu_check',$CON);
        $this->assign('menu_list',$menu_list);
    }

    public function index(){
        $product=M("product");
        $count=$product->where("status=2")->count();
        $Page  = new \Think\Page($count, 20);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $page  = $Page->show();
        $list= $product->limit($Page->firstRow.','.$Page->listRows)->where(array('status'=>array('IN',array(1,2))))->select();
        foreach($list as $key => $val){
            if(session('user.role')<3 && $list[$key]['status']==1){
                $list[$key]['review'] = 1;
            }else{
                $list[$key]['review'] = 0;
            }
        }
        $this->assign("page", $page);
        $this->assign('list',$list);
        $this->assign('action_check',CONTROLLER_NAME."/".ACTION_NAME);
        $this->display();
    }

    public function add(){
        $this->assign('action_check',CONTROLLER_NAME."/".ACTION_NAME);
        $this->display();
    }

    public function save(){
        // if($_FILES){
        //     $upload = new \Think\Upload();// 实例化上传类
        //     $upload->maxSize   =     3145728 ;// 设置附件上传大小
        //     $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg', 'doc','docx','rmvb');// 设置附件上传类型
        //     $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        //     $upload->savePath  =     ''; // 设置附件上传（子）目录
        //     // 上传单个文件
        //     $info   =   $upload->upload();
        //     if($info) {
        //         $file['file_name'] = $info['news_pic']['name'];
        //         $file['file_path'] = "/Uploads/" . $info['news_pic']['savepath'] . $info['news_pic']['savename'];
        //         $file['file_size'] = $info['news_pic']['size'];
        //         $file['file_ext'] = $info['news_pic']['ext'];
        //         $file['create_time'] = date("Y-m-d H:i:s" ,time());
        //         $file_id = M('file')->add($file);
        //         if($file_id){
        //             $this->writeLog("用户上传文件:".$file_id);
        //             $save['file_id'] = $file_id;
        //         }
        //     }
        // }
        $save['name'] = $_POST['name'];
        // $save['menu_id'] = $_POST['kind'];
        // $save['content'] = $_POST['container'];
        $save['abstract'] = $_POST['abstract'];
        $arr=explode("/",$_POST['url']);
        $fun=array_pop($arr);
        $con=array_pop($arr);
        $save['url']=$con."/".$fun;
        // $save['article_time'] = $_POST['article_time'];
        // $save['create_id'] = session('user.id');
        $save['update_time'] = date("Y-m-d H:i:s" ,time());
        $save['status'] = 1;
        // $save['top'] = 0;
        $res = M('product')->add($save);
        if($res){
            $this->writeLog("用户添加产品关键词:".$res);
            $this->success("添加成功","index");
        }else{
            $this->errer("添加失败！");
        }
    }

    public function see(){
        $id=I("get.id");
        $info=M("product")->where('id='.$id)->find();
        $this->assign('action_check',CONTROLLER_NAME."/index");
        $this->assign('info',$info);
        $this->display();
    }

    public function edit(){
        $id=I("get.id");
        $info=M("product")->where('id='.$id)->find();
        $this->assign('action_check',CONTROLLER_NAME."/index");
        $this->assign('info',$info);
        $this->display();
    }

    public function update(){
        // if($_FILES){
        //     $upload = new \Think\Upload();// 实例化上传类
        //     $upload->maxSize   =     3145728 ;// 设置附件上传大小
        //     $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg', 'doc','docx','rmvb');// 设置附件上传类型
        //     $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        //     $upload->savePath  =     ''; // 设置附件上传（子）目录
        //     // 上传单个文件
        //     $info   =   $upload->upload();
        //     if($info) {
        //         $file['file_name'] = $info['news_pic']['name'];
        //         $file['file_path'] = "/Uploads/" . $info['news_pic']['savepath'] . $info['news_pic']['savename'];
        //         $file['file_size'] = $info['news_pic']['size'];
        //         $file['file_ext'] = $info['news_pic']['ext'];
        //         $file['create_time'] = date("Y-m-d H:i:s" ,time());
        //         $file_id = M('file')->add($file);
        //         if($file_id){
        //             $this->writeLog("用户上传文件:".$file_id);
        //             $save['file_id'] = $file_id;
        //         }
        //     }
        // }
        $save['name'] = $_POST['name'];
        // $save['menu_id'] = $_POST['kind'];
        $arr=explode("/",$_POST['url']);
        $fun=array_pop($arr);
        $con=array_pop($arr);
        $save['url']=$con."/".$fun;
        $save['abstract'] = $_POST['abstract'];
        // $save['article_time'] = $_POST['article_time'];
        // $save['create_id'] = session('user.id');
        $save['update_time'] = date("Y-m-d H:i:s" ,time());
//        $save['status'] = 1;
        $res = M('product')->where('id='.$_POST['id'])->save($save);
        if($res){
            $this->writeLog("用户修改产品关键词:".$_POST['id']);
            $this->success("修改成功","index");
        }else{
            $this->errer("修改失败！");
        }
    }

    public function del(){
        $id = $_POST['id'];
        $update_data['status'] = 0 ;
        // $update_data['create_id'] = session('user.id');
       $update_data['update_time'] = date("Y-m-d H:i:s",time());
        $re = M('product')->where('id='.$id)->save($update_data);
        if($re){
            $this->writeLog("用户删除产品关键词:".$_POST['id']);
            $data['status'] = 1;
            $data['info'] = "删除成功!";
        }else{
            $data['status'] = 0;
            $data['info'] = "删除失败!";
        }
        echo json_encode($data);
    }

    public function del_img(){
        $id = $_POST['id'];
        $save['file_id'] = NULL;
        $res = M('article')->where('id='.$id)->save($save);
        if($res){
            $this->writeLog("用户删除文件:".$_POST['id']);
            $data['status'] = 1;
            $data['info'] = "删除成功!";
        }else{
            $data['status'] = 0;
            $data['info'] = "删除失败!";
        }
        echo json_encode($data);
    }

    public function review(){
        $id=I("get.id");
        $info=M("product")->where('id='.$id)->find();
        $this->assign('action_check',CONTROLLER_NAME."/index");
        $this->assign('info',$info);
        $this->display();
    }

    public function update_status(){
        $id = $_POST['id'];
        $update_data['status'] = $_POST['status'] ;
        // $update_data['create_id'] = session('user.id');
        $update_data['update_time'] = date("Y-m-d H:i:s",time());
        $re = M('product')->where('id='.$id)->save($update_data);
        if($re){
            $this->writeLog("用户审核产品关键词:".$_POST['id']);
            $data['status'] = 1;
            if($_POST['status']==2){
                $data['info'] = "审核成功!";
            }else{
                $data['info'] = "否决成功!";
            }
        }else{
            $data['status'] = 0;
            if($_POST['status']==2){
                $data['info'] = "审核失败!";
            }else{
                $data['info'] = "否决失败!";
            }
        }
        echo json_encode($data);
    }

    public function top(){
        $id = $_POST['id'];
//        if(M('article')->where('id='.$id)->getField('file_id')){
        M('article')->where('top=1')->save(array('top'=>0));
        $update_data['top'] = 1 ;
        $update_data['create_id'] = session('user.id');
        $update_data['create_time'] = date("Y-m-d H:i:s",time());
        $re = M('article')->where('id='.$id)->save($update_data);
        if($re){
//            $this->writeLog("用户审核新闻:".$_POST['id']);
            $data['status'] = 1;
            $data['info'] = "置顶成功!";
        }else{
            $data['status'] = 0;
            $data['info'] = "置顶失败!";
        }
//        }else{
//            $data['status'] = 0;
//            $data['info'] = "该新闻缺少图片，不可置顶!";
//        }
        echo json_encode($data);
    }
}


