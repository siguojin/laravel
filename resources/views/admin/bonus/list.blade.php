@extends('comment.admin_base')

@section('title','管理后台红包列表')


<!--页面顶部信息-->
@section('pageHeader')
    <div class="pageheader">
        <h2><i class="fa fa-home"></i> 红包列表 <span>Subtitle goes here...</span></h2>
        <div class="breadcrumb-wrapper">
            <a class="btn btn-sm btn-danger" href="/admin/bonus/add">+ 添加红包</a>
        </div>
    </div>
@endsection

@section('content')

    <div class="row" id="list">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-primary  mb30">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>红包名字</th>
                        <th>红包金额</th>
                        <th>使用条件</th>
                        <th>有效天数</th>
                        <th>发送开始日期</th>
                        <th>发送结束日期</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                @if(!empty($bonus_list))
                 @foreach($bonus_list as $v)
                    <tr>
                        <td>{{$v->id}}</td>
                        <td>{{$v->bonus_name}}</td>
                        <td>{{$v->money}}</td>
                        <td>{{$v->min_money}}</td>
                        <td>{{$v->expires}}</td>
                        <td>{{$v->send_start_time}}</td>
                        <td>{{$v->send_end_time}}</td>
                        <td>{{$v->status==1 ? "可用"  : "不可用"}}</td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="/admin/bonus/send/{{$v['id']}}">发红包</a>
                            <a class="btn btn-sm btn-success" href="/admin/ad/edit">编辑</a>
                            <a class="btn btn-sm btn-danger" href="/admin/bonus/del/{{$v['id']}}">删除</a>
                        </td>
                    </tr>
                 @endforeach
                @endif
                    </tbody>
                </table>
            </div><!-- table-responsive -->
        </div>
    </div>
    <script src="/js/vue.js"></script>
@endsection