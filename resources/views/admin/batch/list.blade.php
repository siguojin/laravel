@extends('comment.admin_base')

@section('title','管理后台批次列表')


<!--页面顶部信息-->
@section('pageHeader')
    <div class="pageheader">
        <h2><i class="fa fa-home"></i> 广告列表 <span>Subtitle goes here...</span></h2>
        <div class="breadcrumb-wrapper">
            <a class="btn btn-sm btn-danger" href="/admin/batch/add">+ 添加批次</a>
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
                        <th>文件路径</th>
                        <th>批次类型</th>
                        <th>内容</th>
                        <th>状态</th>
                        <th>备注</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($list))
                            @foreach($list as $v)
                    <tr>
                        <td>{{$v['id']}}</td>
                        <td>{{$v['file_path']}} </td>                  
                        <td>{{$v['type']}}</td>
                        <td>{{$v['content']}}</td>
                         <td>{{$v['status']}}</td>
                        <td>{{$v['note']}}</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="/admin/batch/do/{{$v['id']}}">执行</a>
                            <a class="btn btn-sm btn-danger" href="/admin/batch/del/{{$v['id']}}">删除</a>
                        </td>
                    </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div><!-- table-responsive -->
        </div>
    </div>
    <script src="/js/vue.min.js"></script>
@endsection