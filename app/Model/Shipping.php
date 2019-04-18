<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    //
    protected $table="jy_shipping";

    public $timestamps=false;

    //配送页面
    public function list(){
    	return self::select()
    			->get()
    			->toArray();
    }

    //执行添加配送
    public function doAdd($data){
    	return self::insert($data);
    }

    //配送删除
    public function del($id){
    	return self::where('id',$id)->delete();
    }

}
