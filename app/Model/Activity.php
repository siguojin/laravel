<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $table="jy_artivity";
    public $timestamps = false;

    //活动添加 
    public function store($data){
    	return self::insert($data);
    }

    public function list(){
    	return self::select()
    			->get()
    			->toArray();
    }

    public function del($id){
    	return self::where('id',$id)->delete();
    }

    public function edit($id){
    	return self::where('id',$id)->first();
    }
    public function doEdit($data,$id){
    	return self::where("id",$id)->update($data);
    }
}
