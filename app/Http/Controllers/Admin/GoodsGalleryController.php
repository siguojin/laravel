<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsGallery;
class GoodsGalleryController extends Controller
{
    //商品相册列表数据
   	public function getGallery($goodsId){

   		$return=[
   			'code'=>2000,
   			'msg'=>'获取列表成功'
   		];

   		$galery=new GoodsGallery();

   		$where=[
   			'goods_id'=>$goodsId
   		];

   		$list=$this->getLists($galery,$where);

   		$return['data']=$list;

   		return json_encode($return);
   	} 

   	//指向相册删除
   	public function del($id){



   		$return =[
   			'code'=>2000,
   			'msg'=>"成功"
   		];
   		$gallery=new GoodsGallery();

   		$res=$this->delRecord($gallery,$id);

   		return ($res);die;

   		if(!$res){
   			$return=[
   				'code'=>4001,
   				'msg'=>"删除相册失败"
   			];
   		}

   		return json_encode($retrun);
   	}
}
