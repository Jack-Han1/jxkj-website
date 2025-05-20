<?php
namespace Home\Controller;
use Think\Controller;

class AboutController extends CommonController
{
    function _initialize(){
        parent::_initialize();
        $CON = M('menu')->where('url="'.CONTROLLER_NAME.'" and status=1 and kind=3')->find();
        $menu_list = M('menu')->where('pid='.$CON['id'].' and status=1')->order('order_by asc')->select();
        $this->assign('menu_check',$CON);
        $this->assign('menu_list',$menu_list);
    }

    public function index(){
        $content=M("content");
        $count=$content->where("status=2")->count();
        $Page  = new \Think\Page($count, 20);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $page  = $Page->show();
        $list= $content->limit($Page->firstRow.','.$Page->listRows)->where(array('status'=>array('IN','1,2')))->order('sort asc')->select();
        // var_dump($list);
        for($i=0;$i<count($list);$i++){
            $list[$i]['show_id']=$i+1;
        }
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
        $content=M("content");
        $data=array(
            'name'=>'新增子菜单',
            'menu_id'=>61,
            'create_id'=>session('user.id'),
            'create_time'=>date('Y-m-d H-i-s'),
            'status'=>1
        );
        $content->add($data);            
        $this->redirect('index');
    }

    public function save(){
        $data=array(
            'title'=>I('post.name'),
            'status'=>1,
            'sort'=>I('post.sort'),
            'create_id'=>session('user.id'),
            'create_time'=>date('Y-m-d H-i-s')
        );
        $cover=I('post.cover')?I('post.cover'):0;
        $pid=M('pic_dir')->add($data);
        if($_FILES){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','JPG','PNG','JPEG','GIF');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传单个文件
            $info   =   $upload->upload();
            if($info) {
                $i=0;
                foreach($info as $key =>$val){
                    if($cover == $i){
                        $file['is_cover']=1;
                    }else{
                        $file['is_cover']=0;
                    }
                    $i++;
                    $file['title'] = $val['name'];
                    $file['pid'] = $pid;
                    $file['status'] = 1;
                    $file['create_id'] = session('user.id');
                    $file['create_time'] = date('Y-m-d H-i-s');
                    $file['url'] = "/Uploads/" . $val['savepath'] . $val['savename'];
                    // die;
                    $file_id = M('staff')->add($file);
                }
                if($file_id){
                    $this->writeLog("用户上传文件:".$file_id);
                }
            }
        }
        if($pid){
            $this->writeLog("用户添加图集:".$pid);
            $this->success("添加成功","staff");
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
        $info=M("content")->where('id='.$id)->find();
        // $info['content']=htmlentities($info['content']);
        $this->assign('action_check',CONTROLLER_NAME."/index");
        $this->assign('info',$info);
        $this->assign('id',$id);
        $this->display();
    }

    public function update(){
        // $save['name'] = $_POST['name'];
        $save['id'] = $_POST['id'];
        $save['content'] = $_POST['container'];
        $save['sort'] = $_POST['sort'];
        //$save['url'] = 'About/introduce';
        $save['update_time'] = date("Y-m-d H:i:s" ,time());
//        $save['status'] = 1;
        $res = M('content')->where('id='.$_POST['id'])->save($save);
        if($res){
            $this->writeLog("用户修改内容:".$_POST['id']);
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
        $re = M('content')->where('id='.$id)->save($update_data);
        if($re){
            $this->writeLog("用户删除内容:".$_POST['id']);
            $data['status'] = 1;
            $data['info'] = "删除成功!";
        }else{
            $data['status'] = 0;
            $data['info'] = "删除失败!";
        }
        echo json_encode($data);
    }

    public function del_staff(){
        $id = $_POST['id'];
        $update_data['status'] = 0 ;
        // $update_data['create_id'] = session('user.id');
        $update_data['update_time'] = date("Y-m-d H:i:s",time());
        $re = M('pic_dir')->where('id='.$id)->save($update_data);
        if($re){
            $this->writeLog("用户删除图集:".$_POST['id']);
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
        $info=M("content")->where('id='.$id)->find();
        $this->assign('action_check',CONTROLLER_NAME."/index");
        $this->assign('info',$info);
        $this->display();
    }

    public function update_status(){
        $id = $_POST['id'];
        $update_data['status'] = $_POST['status'] ;
        // $update_data['create_id'] = session('user.id');
        $update_data['update_time'] = date("Y-m-d H:i:s",time());
        $re = M('content')->where('id='.$id)->save($update_data);
        if($re){
            $this->writeLog("用户审核内容:".$_POST['id']);
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

    public function staff(){
        $pic_dir=M('pic_dir');
        $count=$pic_dir->where("status=1")->count();
        $Page  = new \Think\Page($count, 12);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $page  = $Page->show();
        $dir=$pic_dir->field('id,title')->limit($Page->firstRow.','.$Page->listRows)->where(array('status'=>1))->order('sort asc,update_time desc')->select();
        foreach($dir as $key => $val){
            $dir[$key]['cover_pic']=M('staff')->where(array('pid'=>$val['id'],'is_cover'=>1,'status'=>1))->getField('url');
            $dir[$key]['count']=M('staff')->where(array('pid'=>$val['id'],'status'=>1))->count();
        }
        // var_dump($dir);
        $this->assign("page", $page);
        $this->assign('list',$dir);
        $this->assign('action_check',CONTROLLER_NAME."/".ACTION_NAME);
        $this->display();
    }
    public function staff_add(){
        $this->assign('action_check',CONTROLLER_NAME."/staff");
        $this->display();
    }
    public function picUpload(){
        $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','JPG');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =     'temp'; // 设置附件上传（子）目录
            // 上传单个文件
            $info   =   $upload->upload();
            $this->ajaxReturn($info);
    }
    public function staff_edit(){
        $id=I('get.id');
        $info=M('pic_dir')->where(array('id'=>$id,'status'=>1))->find();
        $picList=M('staff')->where(array('pid'=>$id,'status'=>1))->select();
        // var_dump($picList);
        $this->assign('id',$id);
        $this->assign('picList',$picList);
        $this->assign('info',$info);
        $this->assign('action_check',CONTROLLER_NAME."/staff");
        $this->display();
    }
    public function staff_update(){
        $pid=I("post.id");
        // var_dump($pid);
        $data=array(
            'title'=>I('post.name'),
            'status'=>1,
            'sort'=>I('post.sort'),
            'update_time'=>date('Y-m-d H-i-s')
        );
        $cover=I('post.cover')?I('post.cover'):0;
        $res=M('pic_dir')->where(array('id'=>$pid))->save($data);
        $isset = I('post.isset');
        if($isset == 1){
            M('staff')->where(array('pid'=>$pid))->save(array('is_cover'=>0));
            M('staff')->where(array('id'=>$cover))->save(array('is_cover'=>1));
        }
        // var_dump($_FILES);
        if($_FILES){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg' , 'JPG','PNG','JPEG','GIF');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传单个文件
            $info   =   $upload->upload();
            if($info) {
                $i=0;
                foreach($info as $key =>$val){
                    if($cover == $i){
                        M('staff')->where(array('pid'=>$pid))->save(array('is_cover'=>0));
                        $file['is_cover']=1;
                    }else{
                        $file['is_cover']=0;
                    }
                    $i++;
                    $file['title'] = $val['name'];
                    $file['pid'] = $pid;
                    $file['status'] = 1;
                    $file['create_id'] = session('user.id');
                    $file['create_time'] = date('Y-m-d H-i-s');
                    $file['url'] = "/Uploads/" . $val['savepath'] . $val['savename'];
                    // die;
                    $file_id = M('staff')->add($file);
                }
            }
        }
        // $count = count($_FILES);
        // foreach($_FILES as $key => $value){
        //     $a=(string)strpos($key,'-',0);
        //     if($a == '0'){
        //         $id=str_replace('-file','',$key);
        //         M('staff')->where(array('id'=>$id))->save(array('status'=>0,'update_time'=>date('Y-m-d H-i-s')));
        //         // die;
        //     }else{
        //         $id=str_replace('file','',$key);
        //         $isset=M('staff')->where(array('id'=>$id))->find();
        //         if($isset){
        //             $save['update_time']=date('Y-m-d H-i-s');
        //             if($cover == $id){
        //                 M('staff')->where(array('pid'=>$pid))->save(array('is_cover'=>0));
        //                 M('staff')->where(array('id'=>$id))->save(array('is_cover'=>1));
        //             }
        //             if($value['error'] == 0){
        //                 $upload = new \Think\Upload();// 实例化上传类
        //                 $upload->maxSize   =     3145728 ;// 设置附件上传大小
        //                 $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        //                 $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        //                 $upload->savePath  =     ''; // 设置附件上传（子）目录
        //                 // 上传单个文件
        //                 $info   =   $upload->upload();
        //                 foreach($info as $key_ => $val_){
        //                     $data=$save;
        //                     $data['url'] = "/Uploads/" . $val_['savepath'] . $val_['savename'];
        //                     M('staff')->where(array('id'=>$id))->save($data);
        //                 }
        //             }else{
        //                 M('staff')->where(array('id'=>$id))->save($save);
        //             }
        //         }else{
        //             $upload = new \Think\Upload();// 实例化上传类
        //             $upload->maxSize   =     3145728 ;// 设置附件上传大小
        //             $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        //             $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        //             $upload->savePath  =     ''; // 设置附件上传（子）目录
        //             // 上传单个文件
        //             $info   =   $upload->upload();
        //             if($info) {
        //                 // $j=1;
        //                 foreach($info as $key =>$val){
        //                     if($cover == $count){
        //                         M('staff')->where(array('pid'=>$pid))->save(array('is_cover'=>0));
        //                         $file['is_cover']=1;
        //                     }else{
        //                         $file['is_cover']=0;
        //                     }
        //                     $j++;
        //                     $file['title'] = $val['name'];
        //                     $file['pid'] = $pid;
        //                     $file['status'] = 1;
        //                     $file['create_id'] = session('user.id');
        //                     $file['create_time'] = date('Y-m-d H-i-s');
        //                     $file['url'] = "/Uploads/" . $val['savepath'] . $val['savename'];
        //                     // die;
        //                     $file_id = M('staff')->add($file);
        //                 }
        //                 if($file_id){
        //                     $this->writeLog("用户上传文件:".$file_id);
        //                 }
        //             }
        //         }
        //     }
        // }

        if($res){
            $this->writeLog("用户修改图集:".$id);
            $this->success("修改成功","staff");
        }else{
            $this->errer("修改失败！");
        }
    }
    public function staff_del(){
        $id = I("get.id");
        $res=M('staff')->where(array('id'=>$id))->save(array('status'=>0));
        if($res){
            $this->ajaxReturn(array('code'=>1));
            $this->writeLog("用户删除图片:".$id);
            $this->success("删除成功","staff_del");
        }else{
            $this->errer("删除失败！");
        }
    }
    public function picList(){
        $id=I('post.id');
        $picList=M('staff')->where(array('pid'=>$id,'status'=>1))->select();
        $this->ajaxReturn(array('picList'=>$picList));
    }

    public function magazine(){
        // $list = M('magazine')->where(array('status' => 1))
        // ->order('sort asc')->select();
        $list = M('magazine')->where(array('status' => 1))->order('date DESC')->select();
        $this->assign('list', $list);
        $this->display();
    }

    // public function edit(){
    //     $id=I("get.id");
    //     $info=M("content")->where('id='.$id)->find();
    //     // $info['content']=htmlentities($info['content']);
    //     $this->assign('action_check',CONTROLLER_NAME."/index");
    //     $this->assign('info',$info);
    //     $this->assign('id',$id);
    //     $this->display();
    // }

    public function edit_magazine(){
        $id=I("get.id");
        $info=M("magazine")->where('id='.$id)->find();
        
        // $info['content']=htmlentities($info['content']);
        $this->assign('action_check',CONTROLLER_NAME."/index");
        $this->assign('info',$info);
        $this->assign('id',$id);
        $this->display();
    }

    public function update_magazine(){
        $save['id'] = $_POST['id'];
        $save['text'] = $_POST['text'];
        // $save['sort'] = $_POST['sort'];
        $save['sort'] = 0;
        // 不让管理员改显示优先级
        $save['title'] = $_POST['title'];
        $save['img'] = $_POST['img'];
        $save['url'] = $_POST['url'];
        $save['date'] = $_POST['date'];
        $save['create_id'] = session('user.id');
        //$save['url'] = 'About/introduce';
        $save['update_time'] = date("Y-m-d H:i:s" ,time());
//        $save['status'] = 1;
        $res = M('magazine')->where('id='.$_POST['id'])->save($save);
         // 按 date 字段降序排序（从新到旧）
        // $res = M('magazine')->where('id='.$_POST['id'])->order('date DESC')->save($save);
        if($res){
            $this->writeLog("用户修改内容:".$_POST['id']);
            $this->success("修改成功","index");
            $this->redirect('magazine');
        }else{
            $this->errer("修改失败！");
        }
    }

    public function del_magazine(){
        $id = $_POST['id'];
        $update_data['status'] = 0 ;
        $update_data['create_id'] = session('user.id');
        $update_data['update_time'] = date("Y-m-d H:i:s",time());
        $re = M('magazine')->where('id='.$id)->save($update_data);
        if($re){
            $this->writeLog("用户删除月刊:".$_POST['id']);
            $data['status'] = 1;
            $data['info'] = "删除成功!";
            // $this->redirect('magazine');
        }else{
            $data['status'] = 0;
            $data['info'] = "删除失败!";
        }
        echo json_encode($data);
    }


    // public function add(){
    //     $content=M("content");
    //     $data=array(
    //         'name'=>'新增子菜单',
    //         'menu_id'=>61,
    //         'create_id'=>session('user.id'),
    //         'create_time'=>date('Y-m-d H-i-s'),
    //         'status'=>1
    //     );
    //     $content->add($data);            
    //     $this->redirect('index');
    // }


    public function add_magazine(){
        $content=M("magazine");
        $data=array(
            'title'=>$_POST['title'],
            'text'=>$_POST['text'],
            'img'=>$_POST['img'],
            'url'=>$_POST['url'],
            'date'=>$_POST['date'],
            'sort'=>0,
            'update_time'=>date("Y-m-d H:i:s",time()),
            'status'=>1,
            'create_id'=> session('user.id'),
        );
        $content->add($data);        
        $this->redirect('magazine');
    }
}


