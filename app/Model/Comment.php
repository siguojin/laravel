<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //商品评论表
    protected $table="jy_comment";

    const
    	GODDS_TYPE=1,//商品评论
    	END       =true;

    //商品评论列表
    public  function getCommentList($where=[]){
    	return self::select('jy_comment.id','goods_name','username','jy_user.image_url','jy_comment.content')
    			->leftJoin("jy_goods",'jy_comment.comment_id','=','jy_goods.id')
    			->leftJoin("jy_user",'jy_comment.user_id','=','jy_user.id')
    			->where('type',self::GODDS_TYPE)
    			->where($where)
    			->paginate(2);
    }		

    //商品评论删除
    public function del($id){
    	return self::where('id',$id)->delete();
    }
}
