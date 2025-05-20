<?php
namespace Admin\Controller;
use Think\Controller;

class ResponsibilityController extends CommonController
{
    function _initialize(){
        parent::_initialize();
    }
    // 社会责任->社会责任
    public function charitable(){
        $top_warm = M('article')->where('menu_id=87 and status=2 and top=1')->order('sort asc, article_time desc')->limit(0,3)->select();
        foreach ($top_warm as $key => $val) {
            $top_warm[$key]['date'] = substr($val['article_time'],0,10);

            if ($top_warm[$key]['article_time'])
            $top_warm[$key]['create_time'] = $top_warm[$key]['article_time'];
            $top_warm[$key]['year'] = date('Y', strtotime($top_warm[$key]['create_time']));
            $top_warm[$key]['data'] = date('m-d', strtotime($top_warm[$key]['create_time']));
            $top_warm[$key]['news_img'] = M('file')->where('id=' . $top_warm[$key]['file_id'])->getField('file_path');
        }
        
        $top_care = M('article')->where('menu_id=88 and status=2 and top=1')->order('sort asc, article_time desc')->limit(0,3)->select();
        foreach ($top_care as $key => $val) {
            $top_care[$key]['date'] = substr($val['article_time'],0,10);

            $top_care[$key]['news_img'] = M('file')->where('id=' . $top_care[$key]['file_id'])->getField('file_path');
        }
        $this->assign("top_warm_list", $top_warm);
        $this->assign("top_care_list", $top_care);
        $this->display();
    }

    public function warmheart()
    {
        $count = M('article')->where('menu_id=87 and status=2')->count();
        $Page  = new \Think\Page($count, 10);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
        $page  = $Page->show();
        $list =  M('article')->where('menu_id=87 and status=2')->order('article_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        for ($i = 0; $i < count($list); $i++) {
            if (mb_strlen($list[$i]['abstract'], 'utf-8') > 120) {
                $list[$i]['abstract'] = mb_substr($list[$i]['abstract'], 0, 120, 'utf-8') . ". . .";
            }
            if ($list[$i]['article_time'])
                $list[$i]['create_time'] = $list[$i]['article_time'];
            $list[$i]['year'] = date('Y', strtotime($list[$i]['create_time']));
            $list[$i]['data'] = date('m-d', strtotime($list[$i]['create_time']));

            $list[$i]['news_img'] = M('file')->where('id=' . $list[$i]['file_id'])->getField('file_path');
        }

        

        $this->assign("page", $page);
        $this->assign('list', $list);
        $this->display();
    }

    public function staffcare()
    {
        $count = M('article')->where('menu_id=88 and status=2')->count();
        $Page  = new \Think\Page($count, 10);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
        $page  = $Page->show();
        $list =  M('article')->where('menu_id=88 and status=2')->order('article_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        for ($i = 0; $i < count($list); $i++) {
            if (mb_strlen($list[$i]['abstract'], 'utf-8') > 120) {
                $list[$i]['abstract'] = mb_substr($list[$i]['abstract'], 0, 120, 'utf-8') . ". . .";
            }
            if ($list[$i]['article_time'])
                $list[$i]['create_time'] = $list[$i]['article_time'];
            $list[$i]['year'] = date('Y', strtotime($list[$i]['create_time']));
            $list[$i]['data'] = date('m-d', strtotime($list[$i]['create_time']));

            $list[$i]['news_img'] = M('file')->where('id=' . $list[$i]['file_id'])->getField('file_path');
        }

        

        $this->assign("page", $page);
        $this->assign('list', $list);
        $this->display();
    }

    public function warmheart_detail()
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

    public function staffcare_detail()
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


