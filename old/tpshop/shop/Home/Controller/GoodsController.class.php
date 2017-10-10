<?php

namespace Home\Controller;
use Think\Controller;
/**
* 
*/
class GoodsController extends Controller
{
	function showlist(){
        //设置缓存
        S(array('type'=>'memcache','host'=>'127.0.0.1','port'=>11211));
        //改存储的商品信息设置一个名字：goods_category_info
        //线上产品给key其名字 md5(sql语句)
         $info=S('goods_category_info');
         if(empty($info)){
        	echo "此时数据从mysql中而来";
         	//获得商品列表信息
		 $info=D('Goods')->field('goods_id,goods_name,goods_price,goods_small_img')->select();
		 S('goods_category_info',$info,0);
        }

		//$info=D('Goods')->field('goods_id,goods_name,goods_price,goods_small_img')->select();
		//展示到模板;
		$this->assign('info',$info);
		$this->display();
	}
	function detail($goods_id){
		$info=D('Goods')->find($goods_id);
		$this->assign('info',$info);
		// echo "商品详细信息。";
		$this->display();
	}
}
?>