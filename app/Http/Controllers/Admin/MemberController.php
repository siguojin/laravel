<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Member;
use App\Model\UserBonus;

class MemberController extends Controller
{
    //会员列表
    public function list(){

    	$member=new Member();

    	$assign['list']=$this->getListsInfo($member);
    	// dd($assign);

    	return view('admin.member.list',$assign);
    }

    //会员详情
    public function detail($id){

    	$member=new Member();
        $userbonus=new  UserBonus();

    	$assign['info']=$member->getInfo($id);
        $assign['bonus_list'] =$userbonus->getReco($id);
        // dd($assign);

    	return view('admin.member.detail',$assign);
    }
}
