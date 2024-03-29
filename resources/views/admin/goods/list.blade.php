@extends('comment.admin_base')

@section('title','管理后台商品列表')


<!--页面顶部信息-->
@section('pageHeader')
    <div class="pageheader">
        <h2><i class="fa fa-home"></i> 商品列表 <span>Subtitle goes here...</span></h2>
        <div class="breadcrumb-wrapper">
            <a class="btn btn-sm btn-danger" href="/admin/goods/add">+ 添加新商品</a>
        </div>
    </div>
@endsection

@section('content')

    <div class="row" id="goods_list">
        {{csrf_field()}}
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-primary  mb30">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品名称</th>
                        <th>货号</th>
                        <th>价格</th>
                        <th>上架</th>
                        <th>推荐</th>
                        <th>热销</th>
                        <th>新品</th>
                        <th>推荐排序</th>
                        <th>库存</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="goods in dataLists">
                        <td>{goods.id}</td>
                        <td>{goods.goods_name}</td>
                        <td>{goods.goods_sn}</td>
                        <td>{goods.market_price}</td>
                        <td>
        <button class="btn btn-sm btn-success"  v-if="goods.is_shop ==1" @click="changeAttr(goods.id,'is_shop',2)">是</button>
                            <button class="btn btn-sm btn-black" v-else @click="changeAttr(goods.id,'is_shop',1)">否</button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-success"  v-if="goods.is_recommand ==1" @click="changeAttr(goods.id,'is_recommand',2)">是</button>
                            <button class="btn btn-sm btn-black" v-else @click="changeAttr(goods.id,'is_recommand',1)">否</button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-success"  v-if="goods.is_hot ==1" @click="changeAttr(goods.id,'is_hot',2)">是</button>
                            <button class="btn btn-sm btn-black" v-else @click="changeAttr(goods.id,'is_hot',1)">否</button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-success"  v-if="goods.is_new ==1" @click="changeAttr(goods.id,'is_new',2)">是</button>
                            <button class="btn btn-sm btn-black" v-else @click="changeAttr(goods.id,'is_new',1)">否</button>
                        </td>
                        <td>{goods.sort}</td>
                        <td>{goods.goods_num}</td>
                        <td>
                            <button class="btn btn-sm btn-black"  v-if="goods.status == 1" @click="changeAttr(goods.id,'status',2)">未审核</button>
                            <button class="btn btn-sm btn-success" v-else @click="changeAttr(goods.id,'status',1)">已审核</button>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-success" :href=" '/admin/goods/gallery/edit/' +goods.id">属性</a>
                            <a class="btn btn-sm btn-success" :href=" '/admin/goods/edit/' +goods.id">编辑</a>
                            <a class="btn btn-sm btn-danger" @click=goodsDel(goods.id)>删除</a>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <ul class="pagination" v-if="total_page >1">
                    <li v-bind:class="current_page <=1 ? 'disabled' :''"><span>«</span></li>
                    <li v-for="num in total_page" :class="current_page == num ? 'active' : ''"><span>{num}</span></li>
                    <li v-bind:class="current_page >= total_page ? 'disabled' :''"><a href="#" rel="next">»</a></li>
                </ul>

            </div><!-- table-responsive -->
        </div>
    </div>
    <script src="/js/vue.min.js"></script>
    <script type="text/javascript">
        var app = new Vue({
            el: "#goods_list",
            delimiters: ['{','}'],
            data: {
                dataLists: [],
                current_page:1,
                total_page:1
            },
            //构造函数
            created:function(){
                this.getGoodsList();
            },
            methods: {
                //商品列表
                getGoodsList: function(){
                    var that = this;

                    $.ajax({
                        url: "/admin/goods/get/data",
                        type: "post",
                        data: {_token:$('input[name=_token]').val(),page:that.current_page},
                        dataType:"json",
                        success: function(res){
                            if(res.code == 2000){
                                that.dataLists = res.data.list;
                                that.current_page = res.data.current_page;
                                that.total_page = res.data.last_page;
                            }
                        }
                    });
                },
                //上一页
                prevPage:function(){
                    if(this.current_page<=1){
                        return false;
                    }
                    this.current_page = this.current_page-1;

                    this.getGoodsList();
                },
                //下一页
                nextPage:function(){
                    if(this.current_page >= this.total_page){
                        return false;
                    }
                    this.current_page = this.current_page+1;

                    this.getGoodsList();
                },
                //修改商品属性
                changeAttr: function(id,key,val){
                    var that = this;

                    $.ajax({
                        url: "/admin/goods/change/attr",
                        type: "post",
                        data: {_token:$('input[name=_token]').val(),id:id,key:key,val:val},
                        dataType:"json",
                        success: function(res){
                            if(res.code=2000){
                                that.getGoodsList();
                            }
                        }
                    })
                },
                //执行删除的操作
                goodsDel:function(id){
                    var that = this;
                    $.ajax({
                        url: "/admin/goods/del/"+id,
                        type: "get",
                        data: {_token:$('input[name=_token]').val()},
                        dataType:"json",
                        success: function(res){
                            if(res.code==2000){
                                that.getGoodsList();
                            }
                        }
                    })
                }
            }
        })
    </script>
@endsection