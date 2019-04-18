@extends("comment.admin_base")

@section("title","管理后台-角色列表")
	<!-- 页面顶部信息 -->
@section('pageHeader')
<div class="pageheader">
      <h2><i class="fa fa-home"></i> 角色列表 <span>Subtitle goes here...</span></h2>
      <div class="breadcrumb-wrapper">
        
      </div>
    </div>
@endsection

@section("content")
{{csrf_field()}}
 <div class="row" id="list">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-success mb30">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>角色名称</th>
                        <th>角色描述</th>
                        <th>操作</th>
                      </tr>
                    </thead>
                    <tbody>
                    	@if(!empty($role_list))
                     			@foreach($role_list as  $role)
                     				<tr>
										<td>{{$role['id']}}</td>
										<td>{{$role['rolename']}}</td>
										<td>{{$role['role_desc']}}</td>
										<td>
											<a href="{{ route('admin.role.edit',['id'=>$role['id'] ] )}}" class="btn btn-sm btn-success">修改</a>
											<a href="{{ route('admin.role.permission',['id'=>$role['id'] ])}}" class="btn btn-sm btn-primary">权限</a>
											<a href="{{ route('admin.role.del',['id'=>$role['id'] ] )}}" class="btn btn-sm btn-danger">删除</a>
										</td>
                   					</tr>
                     		@endforeach
						@endif
                    </tbody>
                </table>
            </div>
        </div>
<script src="/js/vue.min.js"></script>
<script>
</script>
@endsection