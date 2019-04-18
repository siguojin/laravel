<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Activity;

class ActivityController extends Controller
{
    //
	//活动内容
    public function list(){
    	$activity=new Activity();
    	$assign['info']=$activity->list();
    	return view('admin.activity.list',$assign);
    }

    public function add(){
		return view('admin.activity.add');
    }

    public function store(Request $request){
    	$params=$request->all();
    	unset($params['_token']);

    	$activity=new Activity();

    	$activity->store($params);

    	return redirect("/admin/activity/list");	


    }

    public function del($id ){
    	$activity=new Activity();
    	$activity->del($id);

    	return redirect("/admin/activity/list");	
    }


    public function edit($id){
		$activity=new Activity();
		$assign['info']=$activity->edit($id);
    	return view("admin.activity.edit",$assign);
    }

    public function doEdit(Request $request){
    	$params=$request->all();
    	// dd($params);	
    	unset($params['_token']);
    	$activity=new Activity();
    	$id=$params['id'];
    	$res=$activity->doEdit($params,$id);
    	if(!$res){
    		return redirect()->back()->with("msg",'修改失败');
    	}

    	return redirect("/admin/activity/list");

    }

}
