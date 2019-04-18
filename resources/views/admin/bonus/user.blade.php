@extends('comment.admin_base')

@section('title','管理后台红包列表')


<!--页面顶部信息-->
@section('pageHeader')
    <div class="pageheader">
        <h2><i class="fa fa-home"></i> 红包发送记录 <span>Subtitle goes here...</span></h2>
        <div class="breadcrumb-wrapper">
            <!-- <a class="btn btn-sm btn-danger" href="/admin/bonus/add">+ 添加红包</a> -->
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
                        <th>用户名</th>
                        <th>用户手机</th>
                        <th>红包名称</th>
                        <th>红包发送时间</th>
                        <th>使用截止时间</th>
                        <th>状态</th>
                    </tr>
                    </thead>
                    <tbody>
                @if(!empty($bonus_list))
                 @foreach($bonus_list as $v)
                    <tr>
                        <td>{{$v->id}}</td>
                        <td>{{$v->username}}</td>
                        <td>{{$v->phone}}</td>
                        <td>{{$v->bonus_name}}</td>
                        <td>{{$v->start_time}}</td>
                        <td>{{$v->end_time}}</td>
                        <td>@if($v->status==1) 未使用 @elseif($v->status==2) 已使用 @else 已过期 @endif</td>
                        
                    </tr>
                 @endforeach
                @endif
                    </tbody>
                </table>
                {{$bonus_list->links()}}
            </div><!-- table-responsive -->
        </div>
    </div>
    <script src="/js/vue.js"></script>
@endsection