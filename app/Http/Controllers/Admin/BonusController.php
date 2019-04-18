<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Bonus;
use App\Model\UserBonus;
use App\Model\Member;
class BonusController extends Controller
{
    //红包列表
    public function list(){
    	$bonus=new Bonus();

    	$assign['bonus_list']=$this->getListsInfo($bonus);

    	return view("admin.bonus.list",$assign);
    }

    //红包添加页面
    public function add(){
    	return view('admin.bonus.add');
    }

    //执行红包的添加
    public function doAddBonus(Request $request){
    	$params=$request->all();
    	// dd($params);


    	$params=$this->delToken($params);
    	$bonus= new Bonus();
    	// dd($params);
    	$res=$this->storeData($bonus,$params);

    	if(!$res){
    		return redirect()->back()->with("msg",'添加失败');
    	}

    	return redirect('/admin/bonus/list');
    }

    //执行删除
    public function del($id){
    	$bonus= new Bonus();

    	$res=$this->delRecord($bonus,$id);

    	if(!$res){
    		return redirect()->back()->with("msg",'删除失败');
    	}

    	return redirect("/admin/bonus/list");

    }

    //发红包列表
    public function send($bonusId){
    	$bonus = new Bonus();
    	$assign['bonus_info'] = $this->getDataInfo($bonus,$bonusId);
    	return view('admin.bonus.send',$assign);
    }
    //执行发送红包
    public function store(Request $request){
    	$params=$request->all();

    	$params=$this->delToken($params);

    	//查询用户的信息
    	$user=new Member;
		
    	$userInfo=$this->getDataInfo($user,$params['phone'],'phone');
    	// dd($userInfo);
    	if(empty($userInfo)){
    		return redirect()->back()->with("msg",'添加红包失败');
    	}

    	//用户红包的数据
    	$userBonusData = [
    		'user_id' => $userInfo->id,
    		'bonus_id' => $params['bonus_id'],
    		'start_time' => date("Y-m-d H:i:s"),
    		'end_time'   => date('Y-m-d H:i:s',strtotime("+ ".$params['expires']." days")),
    	];

    	$user_Bonus=new UserBonus();

    	$res=$this->storeData($user_Bonus,$userBonusData);
    	if(!$res){
    		return redirect()->back()->with('msg','红包发送失败');
    	}

    	return redirect("/admin/bonus/user");

    }

    //红包领取记录
    public function user($where=[]){

    	$userbonus= new UserBonus();

    	$assign['bonus_list']=$userbonus->getSendRecord($where);
    	// dd($assign);

    	return view("admin.bonus.user",$assign);
    }
}
