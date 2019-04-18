<?php

namespace App\Study;

use Illuminate\Database\Eloquent\Model;

class Guess extends Model
{
    protected $table ="study_guess";

    public $timestamps=false;

    //球队添加
    public function addRecord($data)
    {
        return self::insert($data);
    }

    //球队记录
    public function getGuess()
    {
        return self::get()->toArray();
    }

    //获取球队
    public function getInfo($id)
    {
        return self::where("id",$id)->first();
    }
}
