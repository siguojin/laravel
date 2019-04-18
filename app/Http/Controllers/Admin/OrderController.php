<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderGoods;
use App\Model\Region;
use App\Model\Member;
use App\Tools\ToolsExcel;
class OrderController extends Controller
{
    //订单 
    public function list(){

    	$order= new Order();

    	$assign['list']=$this->getListsInfo($order);
    	// dd($assign);

    	return view("admin.order.list",$assign);
    }
    // 订单详情
    public function detail($id){
    	$order= new Order();
    	$ordergoods= new OrderGoods();
    	$region =new Region();
    	$member =new  Member();	
    	//订单的基本信息 
    	$order=$this->getDataInfo($order,$id);

    	$country=$this->getDataInfo($region,$order->country);//国家
    	$province=$this->getDataInfo($region,$order->province);//省
    	$city=$this->getDataInfo($region,$order->city);//市
    	$district=$this->getDataInfo($region,$order->district);//区

    	$assign=[
    		'country'=>$country->region_name,
    		'province'=>$province->region_name,
    		'city'    =>$city->region_name,
    		'district'=>$city->region_name
    	];

    	$assign['order']=$order;

    	//订单商品信息
    	$assign['ordergoods']=$this->getLists($ordergoods);
    	$assign['member'] = $this->getDataInfo($member, $order->user_id);

    	// dd($assign);
    	return view('admin.order.detail',$assign);
    }
    //订单删除
    public function del($id){
    	$order= new Order();

    	$this->delRecord($order,$id);

    	return redirect("/admin/order/list");
    }
}
