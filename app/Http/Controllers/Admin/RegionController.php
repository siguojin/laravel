<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Region;
use App\Tools\ToolsAdmin;
class RegionController extends Controller
{
    //列表页面
    public  function list($fid=1){
    	$region = new Region();
    	$assign['region_list'] = $this->getLists($region,['p_id'=>$fid]);
    	// dd($assign);
    	return view('admin.region.list',$assign);
    }

    //添加页面
    public function add(){
    	$region=new Region();

    	$regions=$this->getLists($region);

    	$assign['region_list']=ToolsAdmin::buildTreeString($regions,0,0,'p_id');

    	return view('admin.region.add',$assign);
    }

    //执行添加
    public function store(Request $request){
    	$params=$request->all();
    }

    //执行添加
    public function doAdd(Request $request){
    	$params=$request->all();
    	// dd($params);

    	$params = $this->delToken($params);
    	// dd($params);
    	//当前要添加地区的详细信息
    	$region = new Region();
    	$info = $this->getDataInfo($region,$params['p_id']);

    	// dd($info);
    	$params['level'] = $info->level + 1;
    	$res = $this->storeData($region, $params);
    
    	if(!$res){
    		return redirect()->back()->with('msg','添加失败');
    	}
    	return redirect('/admin/region/list/'.'0');
    }

    //地区删除
   	public function del($id){
   		$region=new Region();

   		$info=$this->getDataInfo($region,$id);
   		$this->delRecord($region,$id);

   		return redirect("/admin/region/list/".$info->p_id);



   	}
}
