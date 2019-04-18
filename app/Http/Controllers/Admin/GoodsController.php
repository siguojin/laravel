<?php

namespace App\Http\Controllers\Admin;

use App\Model\Brand;
use App\Model\Category;
use App\Model\Goods;
use App\Model\GoodsType;
use App\Tools\ToolsAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Model\GoodsGallery;

class GoodsController extends Controller
{
    //列表
    public function list()
    {
        return view("admin.goods.list");
    }

    //列表数据
    public function getDataLists(Request $request)
    {
        $params = $request->all();

        $return  = [
            "code" => 2000,
            "msg" =>"获取数据成功",
        ];

        $goods = new Goods();

        $data = $this->getListsInfo($goods)->toArray();

        $return['data'] = [
            "list" => $data['data'],
            "current_page" => $data['current_page'],
            "total_page" => $data['last_page']
        ];

        return json_encode($return);
    }

    //添加页面
    public function add()
    {
        $goodsType = new GoodsType();

        $brand = new Brand();

        $category = new Category();

        $assign['goodsType'] = $this->getLists($goodsType,['status'=>GoodsType::USE_ABLE]);

        $assign['brand'] = $this->getLists($brand,['status'=>Brand::USE_ABLE]);

        $assign['category'] = $this->getLists($category,['status'=>Category::USE_ABLE]);
        $assign['category'] = ToolsAdmin::buildTreeString($assign['category'],0,0,"f_id");
        $assign['goods_sn'] = ToolsAdmin::buildGoodsSn();
        return view("admin.goods.add",$assign);
    }

    //执行添加
    public function doAdd(Request $request)
    {
        $params = $request->all();


        //上传数量限制
        if(isset($params['image_url']) && count($params['image_url'])>2){
            return redirect()->back()->with("msg","已经超过图片上传数量");
        }

        $params = $this->delToken($params);

        //相册信息
        $gallery = $params['image_url'];

        unset($params['image_url']);

        try{
            DB::beginTransaction();

            //添加商品信息
            $goods = new Goods();

            $goodsId = $this->addDataBackId($goods,$params);

            //添加图片
                //格式化数据
            foreach($gallery as $key =>$value){
                //图片地址
                $value['image_url'] = ToolsAdmin::uploadFile($value['image_url']);
                $value['goods_id'] = $goodsId;
                $gallery[$key] = $value;
            }
            $goodsGallery = new GoodsGallery();
            //添加相册
            $this->addDataMany($goodsGallery,$gallery);

            DB::commit();

        }catch(\ Exception $e){

            DB::rollback();

            Log::error("添加失败".$e->getMessage());

            return redirect()->back()->with("msg","添加商品失败");
        }

        return redirect("/admin/goods/list");
    }

    //修改属性值
    public function changeAttr(Request $request){
        $params=$request->all();

        $return=[
            'code'=>2000,
            'msg'=>"修改商品属性成功"
        ];

        $goods=Goods::find($params['id']);

     

        //组装的数据
        $data=[
            $params['key']=>$params['val']
        ];

        $res=$this->storeData($goods,$data);

        if(!$res){

            $retur-[
                'code'=>4000,
                'msg'=>'修改商品属性失效'
            ];
        }

        return json_encode($return);


    }
    //商品删除
    public function del($id){
      
         $return=[
                'code'=>2000,
                'msg'=>"删除成功"
            ];
     
        $goods =new Goods();
        $res=$this->delRecord($goods,$id);

        $gallery=new  GoodsGallery();

        try{

            DB::beginTransaction();

            //删除商品
            $this->delRecord($goods,$id);
            //删除相册
            $this->delRecord($gallery, $id, 'goods_id');

            DB::commit();

            // return json_encode($return);

        }catch(\Exception $e){
            Db::rollback();

            \Log::error("商品删除失败".$e->getMessage);

             $return=[
                'code'=>$e->getCode(),
                'msg'=> $e->getMessage()
            ];

            return json_encode($return);
        }
    
        
    }

    //编辑页面
    public function edit($id){
        $goodsType = new GoodsType();

        $brand = new Brand();

        $category = new Category();

        $assign['goodsType'] = $this->getLists($goodsType,['status'=>GoodsType::USE_ABLE]);

        $assign['brand'] = $this->getLists($brand,['status'=>Brand::USE_ABLE]);

        $assign['category'] = $this->getLists($category,['status'=>Category::USE_ABLE]);
        $assign['category'] = ToolsAdmin::buildTreeString($assign['category'],0,0,"f_id");

        $goods=new Goods();

        $assign['info']=$this->getDataInfo($goods,$id);


        return view("admin.goods.edit",$assign);
    }


    public function doEdit(Request $request){

            $params=$request->all();

            //上传数量限制
         if(isset($params['image_url']) && count($params['image_url'])>5){
            return redirect()->back()->with("msg","已经超过图片上传数量");
        }
        //删除token
        $params = $this->delToken($params);

        //相册信息
        $gallery = $params['gallery'];

        unset($params['gallery']);

        try{
            DB::beginTransaction();

            //添加商品信息
            $goods = Goods::find($params['id']);

             $this->storeData($goods,$params);

            //添加图片
            $gallery_data=[];//初始化的值
                //格式化数据
            foreach($gallery as $key =>$value){
                //判断是否上传图片
                if(array_key_exists('image_url',$value)){
                      $value['image_url'] = ToolsAdmin::uploadFile($value['image_url']);
                      $value['goods_id'] = $params['id'];
                        $gallery_data[$key] = $value;//组装新的数据
                }             
            }


            //2添加的操作
            if(!empty($gallery_data)){
                 $goodsGallery = new GoodsGallery();
            //添加相册
                $this->addDataMany($goodsGallery,$gallery);
            }
           

            DB::commit();

        }catch(\ Exception $e){

            DB::rollback();

            Log::error("添加失败".$e->getMessage());

            return redirect()->back()->with("msg","添加商品失败");
        }

        return redirect("/admin/goods/list");
    }
}
