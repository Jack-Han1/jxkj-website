<?php
namespace Admin\Controller;
use Think\Controller;

class SearchController extends CommonController
{
    function _initialize(){
        parent::_initialize();
    }

    // public function index(){
	//     $txt=I("get.txt");
	//     $this->assign('txt',$txt);
    // 	if(!empty(I("get."))){
	//     	$txt=preg_replace("/(\s+)/"," ",$txt);
	//     	$txt=trim($txt," ");
	//     	$search_arr=explode(" ",$txt);
	//     	// var_dump($search_arr);
	//     	foreach($search_arr as $key =>$value){
	//     		$search_arr2[$key]="%".$value."%";
	//     	}
	//     	$where['name']  = array('like',$search_arr2,"AND");
	// 		$where['abstract']  = array('like',$search_arr2,"AND");
	// 		$where['content']  = array('like',$search_arr2,"AND");
	// 		$where['_logic'] = 'or';
	// 		$map['_complex'] = $where;
	// 		$map['status']  = array('eq',2);
	//     	$article=M("article")->field("id,article_time,name,abstract")->where($map)->select();
	//     	// var_dump(mb_strlen($article[0]['abstract']));
	//     	// var_dump(M("article")->getLastSql());
	//     	// var_dump($article);
	//     	$articleCount=count($article);
	//     	foreach($article as $key => $val){
	//     		foreach($search_arr as $key2 => $val2){
	//     			$article[$key]['name']=str_replace($val2,"<span style='color:red;'>".$val2."</span>",$article[$key]['name']);
	//     			$article[$key]['abstract']=str_replace($val2,"<span style='color:red;'>".$val2."</span>",$article[$key]['abstract']);
	//     		}
	//     		// $article[$key]['name']=str_replace($txt,"<span style='color:red;'>".$txt."</span>",$val['name']);
	//     		$date=explode(" ",$val['article_time']);
	//     		$article[$key]['Ymd']=explode("-",$date[0]);
	//     	}
	//     	// var_dump($article);
	//     	$product=M("product")->where(array('name'=>$txt,'status'=>2))->select();
	//     	$productCount=count($product);
	//     	$this->assign('product',$product);
	//     	$count=$articleCount+$productCount;
	//     	// var_dump(M("article")->getLastSql());
	//     	$this->assign("count",$count);
	//     	$this->assign("article",$article);
	//     	if(!empty($article) || !empty($product)){
	//     		$this->display('search');
	//     	}else{
	//     		$this->display();	
	//     	}
    // 	}else{
    //     	$this->display();
    // 	}
    // }

	public function search()
    {
        $query = '%'.$_POST['query'].'%';
        $map['name'] = array('like', $query);

        $article_cnt =  M('article')->where($map)->count();
        $res = M('article')->where($map)->select();
        
        $Product['article_cnt'] = $article_cnt;
        foreach ($res as $key => $val) {
            $Product['article'][$key]['id'] = $val['id'];
            $Product['article'][$key]['title'] = $val['name'];
            $Product['article'][$key]['abstract'] = $val['abstract'];
        }

        $map['title'] = array('like', $query);
        $magazine_cnt =  M('magazine')->where($map)->count();
        $res = M('magazine')->where($map)->select();

        $Product['magazine_cnt'] = $magazine_cnt;
        foreach ($res as $key => $val) {
            $Product['magazine'][$key]['id'] = $val['id'];
            $Product['magazine'][$key]['title'] = $val['title'];
            $Product['magazine'][$key]['abstract'] = $val['text'];
        }

        $map['job'] = array('like', $query);
        $map['duty'] = array('like', $query);
        $recruit_cnt =  M('recruit')->where($map)->count();
        $res = M('recruit')->where($map)->select();

        $Product['recruit_cnt'] = $recruit_cnt;
        foreach ($res as $key => $val) {
            $Product['recruit'][$key]['id'] = $val['id'];
            $Product['recruit'][$key]['title'] = $val['title'];
            $Product['recruit'][$key]['abstract'] = $val['duty'];
        }

        echo json_encode($Product);  
    }

    public function searchresult()
    {

		$query = '%'.$_GET['search_word'].'%';
        $map1['name|abstract'] = array('like', $query);
        $map1['menu_id'] = array('in', '19,20,21,22');
        $map1['status'] = 2;

        $article_cnt =  M('article')->where($map1)->count();
        $res = M('article')->where($map1)->order('article_time desc')->select();
        
        $Product['article_cnt'] = $article_cnt;
        foreach ($res as $key => $val) {
            $Product['article'][$key]['id'] = $val['id'];
            $Product['article'][$key]['title'] = $val['name'];
            $Product['article'][$key]['abstract'] = $val['abstract'];
			$Product['article'][$key]['date'] = substr($val['article_time'],0,10);
            if(empty($val['file_id'])){
                $Product['article'][$key]['news_img'] = '';
                continue;
            }
            $file_path = M('file')->where('id=' . $val['file_id'])->getField('file_path');
            $Product['article'][$key]['news_img'] = empty($file_path) ? '' : $file_path;
        }

        $map2['title|text'] = array('like', $query);
        $map2['status'] = 1;
        $magazine_cnt =  M('magazine')->where($map2)->count();
        // $res = M('magazine')->where($map2)->select();
        // 获取符合条件的杂志列表，并按 date 字段排序
        $res = M('magazine')->where($map2)->order('date DESC')->select();

        $Product['magazine_cnt'] = $magazine_cnt;
        foreach ($res as $key => $val) {
            $Product['magazine'][$key]['id'] = $val['id'];
            $Product['magazine'][$key]['title'] = $val['title'];
            $Product['magazine'][$key]['abstract'] = $val['text'];
			$Product['magazine'][$key]['url'] = $val['url'];
			$Product['magazine'][$key]['img'] = $val['img'];
			$Product['magazine'][$key]['date'] = $val['date'];
        }

        $map3['job|duty'] = array('like', $query);
        $map3['status'] = 2;
        $recruit_cnt =  M('recruit')->where($map3)->count();
        $res = M('recruit')->where($map3)->select();

        $Product['recruit_cnt'] = $recruit_cnt;
		$labels = [];
        foreach ($res as $key => $val) {
            $Product['recruit'][$key]['id'] = $val['id'];
            $Product['recruit'][$key]['title'] = $val['title'];
            $Product['recruit'][$key]['abstract'] = $val['duty'];
			$Product['recruit'][$key]['position'] = $val['position'];
			$Product['recruit'][$key]['job'] = $val['job'];
			$labels[$key]['emergency'] = $val['emergency'];
        }


        // $info['data'] = json_encode($Product);
		// $this->assign("article_cnt", $article_cnt);
		// $this->assign("magazine_cnt", $magazine_cnt);
		$this->assign("news_list", $Product['article']);
		$this->assign("magazines_list", $Product['magazine']);
		$this->assign("recruits_list", $Product['recruit']);
		$this->assign("news_cnt", $Product['article_cnt']);
		$this->assign("magazines_cnt", $Product['magazine_cnt']);
		$this->assign("recruits_cnt", $Product['recruit_cnt']);
		$this->assign("labels_list", $labels);
        $this->assign("res", json_encode($Product));
        $this->display();
    }

} 


