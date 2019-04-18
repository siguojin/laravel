<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Comment;
class CommentController extends Controller
{
    //商品评论表
    public function list(){
    	$comment=new Comment();

    	$assign['info']=$comment->getCommentList();

    	// dd($assign);

    	return view('admin.comment.list',$assign);
    }

    //商品删除
   	public function del($id){
   		$comment=new Comment();

   		$res=$comment->del($id);

   		// dd($res);

   		return redirect('/admin/goods/comment/list');
   	}
}
