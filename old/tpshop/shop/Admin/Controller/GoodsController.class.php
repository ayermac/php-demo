<?php
namespace Admin\Controller;
use Tools\AdminController;

/**
* 
*/
class GoodsController extends AdminController
{
	
	function add()
	{
		# code...
        $goods=D('Goods');
		//1、数组方式添加
		// $arr=array(
  //           'goods_name'=>'iphone8',
  //           'goods_price'=>5500,
  //           'goods_weight'=>105,
  //           'goods_number'=>10,
  //           'goods_create_time'=>time()
		// 	);
  //       $z=$goods->add($arr);

        //2、AR方式数据添加

        //$goods->goods_name="samsung8";
        //$goods->goods_number="7";
        //$z=$goods->add();
        //var_dump($z);

        //两个逻辑，展示表单，收集表单信息
        if(!empty($_POST)){
            //处理上传商品图片
            if($_FILES['goods_pic']['error']==0){
                $cfg=array(
                    'rootPath'=>'./uploads/'
                );

                $up=new \Think\Upload($cfg);
                $z=$up->uploadOne($_FILES['goods_pic']);
                //把上传好的图片保存到数据表记录里边
                $bigpathname=$up->rootPath.$z['savepath'].$z['savename'];//图片路径名
                
                
                //制作缩略图
                $im=new \Think\Image();
                $im->open($bigpathname);//打开被处理图片
                $im->thumb(125,125);//制作缩略图
                $smallpathname=$up->rootPath.$z['savepath']."small_".$z['savename'];
                $im->save($smallpathname);//保存缩略图到服务器
                $_POST['goods_big_img']=ltrim($bigpathname,'./');
                $_POST['goods_small_img']=ltrim($smallpathname,'./');


            }
            
            //收集表单
            //var_dump($_POST);
            $info=$goods->create();
            $z=$goods->add($info);
            //设置缓存
             S(array('type'=>'memcache','host'=>'127.0.0.1','port'=>11211));
            //删除缓存
             S('goods_category_info',null);
            if($z){
                $this->makehtml($z);
            	// $this->redirect(分组/控制器/操作方法,参数array,间隔时间,提示信息);//跳转
            	$this->redirect('showlist',array(),2,'数据添加成功');
            }else{
            	$this->redirect('add',array(),2,'数据添加失败');
            }
        }else{
        	//展示表单
        	$this->display();
        }
        
		
	}
    private function makehtml($goods_id){
    //把添加好的商品顺便给生成一个静态页面
                //前台查看商品详情也就直接查看该静态页面
                ob_start();
                //内容输出前台商品详情页面的模板页面(/Home/goods/detail.shtml)
                $info=D('Goods')->find($goods_id);
                $this->assign('info',$info);
                $this->display('Home@Goods/detail');
                $cont=ob_get_contents();
                //把$cont制作成一个静态文件
                file_put_contents('./product/goods_'.$goods_id.'.shtml',$cont );
                ob_end_clean();
}
    function showlist1()
	{
		# code...
		//使用GoodsModel模型类
		$goods=new \Model\GoodsModel();
        //var_dump($goods);
        $this->display();
		
	}

	function showlist(){
        //实现数据分页效果
        $goods=new \Model\GoodsModel();
        //获得数据的总记录数
        $total=$goods->count();
        $per=7;

        //实例化分页类对象
        $page_obj=new \Tools\Page($total,$per);
        //拼装sql语句获得每页信息
        $sql="select * from sw_goods order by goods_id desc ".$page_obj->limit;
        $info=$goods->query($sql);

        //获得页码列表
        $pagelist=$page_obj->fpage();

		//数据库查询操作
        //实例化Model对象，两种方式选其一
        
        //$goods=D('Goods');
        

        //$info=$goods->order('goods_id desc')->select();
        //var_dump($info);

        //以下两个方法直接被定义到父类Congroller里边
        //对Smarty相关方法的封装
        $this->assign('pagelist',$pagelist);
        $this->assign('info',$info);

        $this->display();

	}

	function showlist3(){
		$goods=D('Goods');
        //where() 设置查询条件
		/*$goods->where("goods_name like '诺%' and goods_price > 1000");
*/
		//limit()限制查询条数
		//$goods->limit(5);

		//limit 偏移量，长度
		//$goods->limit(0,9);

		//field()限制查询字段
		//$goods->field('goods_name,goods_price');

        //order()排序查询
        //$goods->order('goods_price');

        //group()分组查询 group by
        //每个品牌下商品总数量
        //select goods_brand_id,count(*) from sw_goods group by goods_brand_id;
        $goods->group('goods_brand_id');
        $goods->field('goods_brand_id,count(*)');
        $info=$goods->select();
        //var_dump($info);
        $this->assign('info',$info);
		$this->display();
	}
    
    function showlist4(){
    	//连贯操作
    	//获得每个品牌下商品的总数量
    	$goods= new \Model\GoodsModel();
    	$info=$goods->group('goods_brand_id')->field('goods_brand_id,count(*)')->select();
    	//select goods_brand_id,count(*) from sw_goods group by goods_brand_id;
    	//var_dump($info);
        $this->assign('info',$info);
		$this->display();

    }
        function update1()
	{
		# code...
		    $goods=new \Model\GoodsModel();
		    $goods->goods_id=168;
		    $goods->goods_name="nokia333";
		    $goods->goods_price=3200;
		    $goods->goods_number=23;
		    //$z=$goods->save();
		    //var_dump($z);

            $this->display();
		
	}
    //function update($goods_id,$height,$addr)
	function update($goods_id){
		//var_dump($_GET);

		//获得被修改的商品信息
		//find()获得数据表记录信息，每次通过一位数组返回一个记录值
		//model对象->find();获得一个记录结果
		//model对象->find(数字);获得主键id值等于数字条件的一个记录结果

        $info=D('Goods');
        
         
        if(!empty($_POST)){
        	// print_r($_POST);
        	$z=$info->save($_POST);
            //var_dump($z);
            //设置缓存
            S(array('type'=>'memcache','host'=>'127.0.0.1','port'=>'11211'));

            //①获得商品的全部信息，给前台 一个新的缓存
           $goods=$info->field('goods_name,goods_price,goods_small_img')->select();
           S('goods_category_info',$goods,0);

            //②直接删除原缓存页面
            S('goods_category_info',null);
        	if($z){
                $this->makehtml($goods_id);
        		$this->redirect('showlist',array(),2,'数据修改成功');
        	}else{
        		$this->redirect('showlist',array('goods_id'=>$goods_id),2,'数据修改失败');
        	}
        }else{
        	$z=$info->find($goods_id);
        //var_dump($z);
            $this->assign('info',$z);
         
        	$this->display();
        }
		
	}

	function del($goods_id){
        $info=M('Goods');
        $z=$info->delete($goods_id);
        //var_dump($z);
        if($z){
        	$this->redirect('showlist',array(),2,'数据删除成功');
        }else{
        	$this->redirect('showlist',array('goods_id'=>$goods_id),2,'数据删除失败');
        }
	}
      
}
?>