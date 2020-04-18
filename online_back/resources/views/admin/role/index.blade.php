@extends('layouts.main')
@section('header')
    <!--表格内容超出限制隐藏,鼠标点击时显示
    table中td文字超出长度用省略号隐藏超出内容，鼠标点击内容全部显示
        参考:https://www.cnblogs.com/cqj98k/p/11468736.html
    --->
    <style>
        table {
            width: 100%;
            float: left;
            table-layout:fixed;
            width:600px;
            border:1px solid #ccc;
        }

        table tr {
            line-height: 25px;
            border:1px solid #ccc;
        }

        table td {
            border:1px solid #ccc;
            text-align:center;
        }
        .MHover{
            border:1px solid #ccc;
            white-space:nowrap;
            text-overflow:ellipsis;
            overflow:hidden;
        }
    </style>
@endsection

@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 角色管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" href="javascript:;" onclick="admin_role_add('添加角色','{{ url("/role/create") }}','800')"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a> </span> <span class="r">共有数据：<strong>{{ $roles->count() }}</strong> 条</span> </div>
        <table class="table table-border table-bordered table-hover table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="6">角色管理</th>
            </tr>
            <tr class="text-c">
                <th width="25"><input type="checkbox" value="" name=""></th>
                <th width="40">ID</th>
                <th width="200">角色名</th>
                <th>用户列表</th>
                <th width="300">描述</th>
                <th width="70">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $key => $role)
            <tr class="text-c">
                <td><input type="checkbox" value="" name=""></td>
                <td>{{ $key }}</td>
                <td>{{ $role->name }}</td>
                <td class="MHover">
                        @foreach($role->user as $user)
                            {{ $user->name }},
                        @endforeach
                </td> <td class="MALL">
                        @foreach($role->user as $user)
                            {{ $user->name }},
                        @endforeach
                </td>
                <td>{{ $role->description }}</td>
                <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','{{ url("/role/$role->id/edit") }}','1')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'{{ $role->id }}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
            </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection

@section('js')

    <script>
        /*管理员-角色-添加*/
        function admin_role_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*管理员-角色-编辑*/
        function admin_role_edit(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
        /*管理员-角色-删除*/
        function admin_role_del(obj,id){
            layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
                $.ajax({
                    type: 'DELETE',
                    url: "{{ url('/role/') }}"+'/'+id,
                    dataType: 'json',
                    data:{
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }

        $(document).ready(function () {
            //表格内容超出限制隐藏,鼠标点击时显示
            $(".MALL").hide();
            $(".MHover").click(function (e) {
                $(this).next(".MALL").css({"position":"absolute","top":e.pageY+5,"left":e.pageX+5}).show();
            });
            $(".MHover").mousemove(function (e) {
                $(this).next(".MALL").css({ "color": "fff", "position": "absolute", "opacity": "0.7", "background-color": "666", "top": e.pageY + 5, "left": e.pageX + 5 });
            });
            $(".MHover").mouseout(function () {
                $(this).next(".MALL").hide();
            });


        })
    </script>

@endsection
