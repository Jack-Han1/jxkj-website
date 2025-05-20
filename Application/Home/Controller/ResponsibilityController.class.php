<?php
namespace Home\Controller;
use Think\Controller;

class ResponsibilityController extends CommonController
{
    function _initialize(){
        parent::_initialize();
        $CON = M('menu')->where('url="'.CONTROLLER_NAME.'" and status=1 and kind=3')->find();
        $menu_list = M('menu')->where('pid='.$CON['id'].' and status=1')->order('order_by asc')->select();
        $this->assign('menu_check',$CON);
        $this->assign('menu_list',$menu_list);
    }

    // 公益慈善
    public function index(){
        $ids = M('menu')->where('id=87 and status=1')->field('id')->select();
        $id_arr = "";
        for($i=0;$i<count($ids);$i++){
            $id_arr .= $ids[$i]['id'];
            if($id_arr!="" && $i<count($ids)-1){
                $id_arr .= ",";
            }
        }
        $count = M('article')->where('menu_id in ('.$id_arr.') and status!=0')->count();
        $Page  = new \Think\Page($count, 20);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $page  = $Page->show();
        $list =  M('article')->where('menu_id in ('.$id_arr.') and status!=0')->order('top desc,article_time desc,create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        for($i=0;$i<count($list);$i++){
            $list[$i]['show_id'] = $Page->firstRow + $i + 1;
            $list[$i]['menu_name'] = M('menu')->where('id='.$list[$i]['menu_id'])->getField('name');
            if($list[$i]['status']==2 && $list[$i]['menu_id']==19 && $list[$i]['top']==0 && $list[$i]['file_id']){
                $list[$i]['is_top'] = 1;
            }else{
                $list[$i]['is_top'] = 0;
            }
            if($list[$i]['status']==1){
                $list[$i]['review'] = 1;
            }else{
                $list[$i]['review'] = 0;
            }
        }
        $this->assign("page", $page);
        $this->assign('list',$list);
        $this->assign('action_check',CONTROLLER_NAME."/".ACTION_NAME);
        $this->display();
    }

    // 员工关怀
    public function staffcare(){
        $ids = M('menu')->where('id=88 and status=1')->field('id')->select();
        $id_arr = "";
        for($i=0;$i<count($ids);$i++){
            $id_arr .= $ids[$i]['id'];
            if($id_arr!="" && $i<count($ids)-1){
                $id_arr .= ",";
            }
        }
        $count = M('article')->where('menu_id in ('.$id_arr.') and status!=0')->count();
        $Page  = new \Think\Page($count, 20);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $page  = $Page->show();
        $list =  M('article')->where('menu_id in ('.$id_arr.') and status!=0')->order('top desc,article_time desc,create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        for($i=0;$i<count($list);$i++){
            $list[$i]['show_id'] = $Page->firstRow + $i + 1;
            $list[$i]['menu_name'] = M('menu')->where('id='.$list[$i]['menu_id'])->getField('name');
            if($list[$i]['status']==2 && $list[$i]['menu_id']==19 && $list[$i]['top']==0 && $list[$i]['file_id']){
                $list[$i]['is_top'] = 1;
            }else{
                $list[$i]['is_top'] = 0;
            }
            if($list[$i]['status']==1){
                $list[$i]['review'] = 1;
            }else{
                $list[$i]['review'] = 0;
            }
        }
        $this->assign("page", $page);
        $this->assign('list',$list);
        $this->assign('action_check',CONTROLLER_NAME."/".ACTION_NAME);
        $this->display();
    }

    public function add(){
        //id为87或者88的菜单
        $where['id']= array('in','87,88');  
        $where['status'] = 1;
//        $where['kind']=array('lt',3);
        $list = M('menu')->where($where)->select();
        $this->assign('list',$list);
        $this->assign('action_check',CONTROLLER_NAME."/".ACTION_NAME);
        $this->display();
    }

    public function save(){
        if($_FILES){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg', 'doc','docx','rmvb');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传单个文件
            $info   =   $upload->upload();
            if($info) {
                $file['file_name'] = $info['news_pic']['name'];
                $file['file_path'] = "/Uploads/" . $info['news_pic']['savepath'] . $info['news_pic']['savename'];
                $file['file_size'] = $info['news_pic']['size'];
                $file['file_ext'] = $info['news_pic']['ext'];
                $file['create_time'] = date("Y-m-d H:i:s" ,time());
                $file_id = M('file')->add($file);
                if($file_id){
                    $this->writeLog("用户上传文件:".$file_id);
                    $save['file_id'] = $file_id;
                }
            }
        }
        $save['top_title'] = $_POST['top_title'];
        $save['name'] = $_POST['name'];
        $save['menu_id'] = $_POST['kind'];
        $save['content'] = $_POST['container'];
        $save['abstract'] = $_POST['abstract'];
        $save['article_time'] = $_POST['article_time'];
        $save['create_id'] = session('user.id');
        $save['create_time'] = date("Y-m-d H:i:s" ,time());
        $save['status'] = 1;
        $save['top'] = $_POST['top'];
        $save['sort'] = $_POST['sort'];
        $res = M('article')->add($save);
        if($res){
            $this->writeLog("用户添加文章:".$res);
            $this->success("添加成功","index");
        }else{
            $this->errer("添加失败！");
        }
    }

    public function edit(){
        // $where['pid']= 86;
        //id为87或者88的菜单
        $where['id']= array('in','87,88');  
        $where['status'] = 1;
//        $where['kind']=array('lt',3);
        $list = M('menu')->where($where)->select();
        $this->assign('list',$list);
        $id = $_GET['id'];
        $info = M('article')->where('id='.$id)->find();
        $info['menu_name'] = M('menu')->where('id='.$info['menu_id'])->getField('name');
        if($info['file_id']){
            $info['pic_info'] = M('file')->where('id='.$info['file_id'])->find();
        }
        $this->assign('action_check',CONTROLLER_NAME."/index");
        $this->assign('info',$info);
        $this->display();
    }

    // 编辑保存
    public function update(){
        if($_FILES){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg', 'doc','docx','rmvb');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传单个文件
            $info   =   $upload->upload();
            if($info) {
                $file['file_name'] = $info['news_pic']['name'];
                $file['file_path'] = "/Uploads/" . $info['news_pic']['savepath'] . $info['news_pic']['savename'];
                $file['file_size'] = $info['news_pic']['size'];
                $file['file_ext'] = $info['news_pic']['ext'];
                $file['create_time'] = date("Y-m-d H:i:s" ,time());
                $file_id = M('file')->add($file);
                if($file_id){
                    $this->writeLog("用户上传文件:".$file_id);
                    $save['file_id'] = $file_id;
                }
            }
        }
        $save['top_title'] = $_POST['top_title'];
        $save['top'] = $_POST['top'];
        $save['sort'] = $_POST['sort'];
        $save['name'] = $_POST['name'];
        $save['menu_id'] = $_POST['kind'];
        $save['content'] = $_POST['container'];
        $save['abstract'] = $_POST['abstract'];
        $save['article_time'] = $_POST['article_time'];
        $save['create_id'] = session('user.id');
        $save['create_time'] = date("Y-m-d H:i:s" ,time());
//        $save['status'] = 1;
        $res = M('article')->where('id='.$_POST['id'])->save($save);
        if($res){
            $this->writeLog("用户修改文章:".$_POST['id']);
            if($_POST['kind'] == 87){
                $this->success("修改成功", "index");
            } elseif($_POST['kind'] == 88){
                $this->success("修改成功", "staffcare");
            }
            // $this->success("修改成功","index");
        }else{
            $this->errer("修改失败！");
        }
    }

    public function del(){
        $id = $_POST['id'];
        $update_data['status'] = 0 ;
        $update_data['create_id'] = session('user.id');
//        $update_data['create_time'] = date("Y-m-d H:i:s",time());
        $re = M('article')->where('id='.$id)->save($update_data);
        if($re){
            $this->writeLog("用户删除文章:".$_POST['id']);
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

    // 文章审核提交
    public function update_status(){
        $id = $_POST['id'];
        $update_data['status'] = $_POST['status'] ;
        $update_data['create_id'] = session('user.id');
        $update_data['create_time'] = date("Y-m-d H:i:s",time());
        $re = M('article')->where('id='.$id)->save($update_data);
        if($re){
            $this->writeLog("用户审核文章:".$_POST['id']);
            $data['status'] = 1;
            $data['info'] = "操作成功!";
        }else{
            $data['status'] = 0;
            $data['info'] = "操作失败!";
        }
        echo json_encode($data);
    }

    // 文章审核展示
    public function review(){
        $id = $_GET['id'];
        $info = M('article')->where('id='.$id)->find();
        $info['menu_name'] = M('menu')->where('id='.$info['menu_id'])->getField('name');
        if($info['file_id']){
            $info['pic_info'] = M('file')->where('id='.$info['file_id'])->find();
        }
        $this->assign('action_check',CONTROLLER_NAME."/index");
        $this->assign('info',$info);
        $this->display();
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


