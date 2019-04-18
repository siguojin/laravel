<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //支付
    protected $table="jy_payment";

    public $timestamps=false;

    //执行添加
    public function doAdd($data){
    	return self::insert($data);
    }
    //支付渲染页面
    public function list(){
    	return self::select()
    				->get()
    				->toArray();
    }

    //支付删除
    public function del($id){
    	return self::where('id',$id)->delete();
    }

    //支付编辑
   	public function edit($id){

   		return self::where('id',$id)->first();
   	}
}
