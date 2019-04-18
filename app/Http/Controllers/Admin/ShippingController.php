<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Shipping; 	

class ShippingController extends Controller
{
    //配送页面
    public function list(){
    	$shipping = new Shipping();

    	$assign['shipping']=$shipping->list();
    	return view("admin.shipping.list",$assign);
    }

    //配送添加页面 
    public function add(){
    	return view('admin.shipping.add');
    }

    //配送添加执行
    public function doAdd(Request $request){
    	$params=$request->all();

    	unset($params['_token']);

    	$shipping = new Shipping();

    	$res=$shipping->doAdd($params);

    	if(!$res){
    		return redirect()->back()->with('msg','添加失败');
    	}

    	return redirect("/admin/shipping/list");
    }

    //支付删除
    public function del($id){
    	$shipping = new Shipping();

    	$shipping->del($id);

    	return redirect("/admin/shipping/lsit"); 	
    }
}
