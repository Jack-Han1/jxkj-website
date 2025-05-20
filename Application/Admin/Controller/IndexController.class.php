<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends CommonController
{
    function _initialize(){
        parent::_initialize();
    }

//     public function index(){
//         //热点
//         $hot_list = M('article')->where('menu_id=20 and status=2')->order('top desc,article_time desc,create_time desc')->find();
//         if($hot_list['article_time'])
//             $hot_list['create_time'] = $hot_list['article_time'];
// //        var_dump($hot_list['create_time']);
//         $hot_list['date'] = date('Y-m-d',strtotime($hot_list['create_time']));
//         $this->assign('hot_list',$hot_list);

//         //第一条要闻
//         $top_list = M('article')->where('menu_id=19 and status=2 and top=1')->order('sort asc,create_time desc')->find();
//         $top_list['date'] = date('Y-m-d',strtotime($top_list['create_time']));
//         if( mb_strlen($top_list['abstract'],'utf-8')>60){
//             $top_list['abstract'] = mb_substr($top_list['abstract'],0,60,'utf-8').". . .";
//         }
//         if($top_list['file_id']){
//             $top_list['pic_info'] = M('file')->where('id='.$top_list['file_id'])->find();
//         }
//         $this->assign('top_list',$top_list);

//         //要闻
//         $news_list = M('article')->where('menu_id=19 and status=2 and top=1')->order('sort asc,create_time desc')->limit(0,7)->select();
//         for($i=0;$i<count($news_list);$i++){
//             if($news_list['article_time'])
//                 $news_list['create_time'] = $news_list['article_time'];
//             $news_list[$i]['date'] = date('Y-m-d',strtotime($news_list[$i]['article_time']));
//         }
//         $this->assign('news_list',$news_list);
//         // var_dump($news_list);
//         $this->display();
//     }
//     public function Legal_notices(){
//         $this->display("Legal_notices");
//     }
    // ------------------------------------------------------------------------------------
    public function index(){
        $top_news = M('article')->where('menu_id=19 and status=2 and top=1')->order('sort asc, article_time desc')->limit(0,3)->select();
        foreach ($top_news as $key => $val) {
            $top_news[$key]['date'] = substr($val['article_time'],0,10);

            $top_news[$key]['news_img'] = M('file')->where('id=' . $top_news[$key]['file_id'])->getField('file_path');
        }
        $this->assign("top_news_list", $top_news);
        $this->display();
    }

}


